<?php

use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $nome = '';
    public $arquivo;
    public int $fileIteration = 1;
    public array $documents = [];

    public ?string $tipo = null;
    public ?int $estudanteId = null;
    public ?int $maxDocuments = null;

    public function updatedArquivo(): void
    {
        $this->validate([
            'arquivo' => 'required|file|max:51200',
        ]);

        if ($this->maxDocuments === 1) {
            $this->removeDocument($this->documents[0]['id'] ?? '');
            $this->addDocument();
        }
    }

    public function updatedNome(): void
    {
        if (($this->maxDocuments ?? 2) === 1) {
            $this->validate([
                'nome' => 'required|string|max:255',
            ]);

            $this->removeDocument($this->documents[0]['id'] ?? '');
            $this->addDocument();
        }
    }

    public function addDocument(): void
    {
        if (count($this->documents) === $this->maxDocuments) {
            return;
        }

        $this->validate([
            'nome' => 'required|string|max:255',
            'arquivo' => 'required|file|max:51200',
        ]);

        $id = (string) Str::uuid();
        $extensao = $this->arquivo->getClientOriginalExtension();
        $fileName = Str::slug($this->nome) . '.' . $extensao;
        $path = $this->arquivo->storeAs('uploads/documents/' . $id, $fileName, 'public');

        $this->documents[] = [
            'id' => $id,
            'nome' => $this->nome,
            'arquivo' => $path,
            'extensao' => $extensao,
            'uploaded_by' => Auth::user()->nome,
            'uploaded_by_id' => Auth::id(),
            'enviado_em' => now()->format('Y-m-d H:i:s'),
        ];

        if (($this->maxDocuments ?? 2) > 1) {
            $this->reset(['nome', 'arquivo']);
            $this->fileIteration++;
        }
    }

    public function removeDocument(string $id): void
    {
        $document = collect($this->documents)->firstWhere('id', $id);

        if (!$document)
            return;

        if (!empty($document['arquivo'])) {
            Storage::disk('public')->deleteDirectory('uploads/documents/' . $id);
        }

        $this->documents = collect($this->documents)
            ->reject(fn($doc) => $doc['id'] === $id)
            ->values()
            ->all();
    }
};
