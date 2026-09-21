<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Database\Seeder;

class DisciplinaSeeder extends Seeder
{
    private const ROMAN_MAP = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
        6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
    ];

    private function numberToRoman(int $number): string
    {
        return self::ROMAN_MAP[$number] ?? (string) $number;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = Curso::select(['id', 'nome', 'quantidade_periodos'])->get();

        if ($cursos->isEmpty()) {
            return;
        }

        $now = now();
        $records = [];

        foreach ($cursos as $curso) {
            $disciplinas = $this->getDisciplinasForCurso($curso->nome, $curso->quantidade_periodos);

            foreach ($disciplinas as $disc) {
                $periodo = min($disc['periodo'], $curso->quantidade_periodos);

                $records[] = [
                    'nome' => $disc['nome'],
                    'ementa' => "Componente curricular de {$disc['nome']} referente ao {$periodo}º período do curso {$curso->nome} - IFPR Campus Curitiba.",
                    'curso_periodo' => $periodo,
                    'curso_id' => $curso->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Inserção em lotes (bulk insert)
        foreach (array_chunk($records, 500) as $chunk) {
            Disciplina::insert($chunk);
        }
    }

    /**
     * Mapeia as disciplinas baseadas na matriz curricular real do IFPR Campus Curitiba.
     */
    private function getDisciplinasForCurso(string $nomeCurso, int $maxPeriodos): array
    {
        $nomeLower = mb_strtolower($nomeCurso);
        $result = [];

        // 1. Cursos Técnicos Integrados ao Ensino Médio (Contém BNCC + Específicas)
        if (str_contains($nomeLower, 'integrado')) {
            $result = array_merge($result, $this->getDisciplinasBNCC($maxPeriodos));

            $especificas = match (true) {
                str_contains($nomeLower, 'administração') => [
                    ['nome' => 'Introdução à Administração', 'periodo' => 1],
                    ['nome' => 'Contabilidade Geral', 'periodo' => 1],
                    ['nome' => 'Gestão de Pessoas', 'periodo' => 2],
                    ['nome' => 'Marketing e Vendas', 'periodo' => 2],
                    ['nome' => 'Gestão Financeira e Orçamentária', 'periodo' => 3],
                    ['nome' => 'Logística e Operações', 'periodo' => 3],
                    ['nome' => 'Empreendedorismo e Inovação', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'informática') => [
                    ['nome' => 'Algoritmos e Lógica de Programação', 'periodo' => 1],
                    ['nome' => 'Fundamentos de Informática e Arquitetura', 'periodo' => 1],
                    ['nome' => 'Programação Orientada a Objetos', 'periodo' => 2],
                    ['nome' => 'Banco de Dados', 'periodo' => 2],
                    ['nome' => 'Desenvolvimento Web', 'periodo' => 3],
                    ['nome' => 'Redes de Computadores', 'periodo' => 3],
                    ['nome' => 'Engenharia de Software', 'periodo' => 4],
                    ['nome' => 'Programação para Dispositivos Móveis', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'jogos digitais') => [
                    ['nome' => 'Introdução ao Desenvolvimento de Jogos', 'periodo' => 1],
                    ['nome' => 'Lógica de Programação para Jogos', 'periodo' => 1],
                    ['nome' => 'Game Design e Roteirização', 'periodo' => 2],
                    ['nome' => 'Arte e Modelagem 2D/3D', 'periodo' => 2],
                    ['nome' => 'Programação de Jogos Digitais', 'periodo' => 3],
                    ['nome' => 'Motores de Jogos (Game Engines)', 'periodo' => 3],
                    ['nome' => 'Áudio e Sonoplastia para Jogos', 'periodo' => 4],
                    ['nome' => 'Projeto e Produção de Jogos', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'eletrônica') => [
                    ['nome' => 'Eletricidade Básica e Circuitos', 'periodo' => 1],
                    ['nome' => 'Desenho Técnico Eletrônico', 'periodo' => 1],
                    ['nome' => 'Eletrônica Analógica', 'periodo' => 2],
                    ['nome' => 'Eletrônica Digital', 'periodo' => 2],
                    ['nome' => 'Microcontroladores e Sistemas Embarcados', 'periodo' => 3],
                    ['nome' => 'Instrumentação Eletrônica', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'mecânica') => [
                    ['nome' => 'Desenho Técnico Mecânico', 'periodo' => 1],
                    ['nome' => 'Metrologia Industrial', 'periodo' => 1],
                    ['nome' => 'Tecnologia dos Materiais', 'periodo' => 2],
                    ['nome' => 'Processos de Usinagem', 'periodo' => 2],
                    ['nome' => 'Elementos de Máquinas', 'periodo' => 3],
                    ['nome' => 'Manutenção Mecânica', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'petróleo e gás') => [
                    ['nome' => 'Introdução à Indústria do Petróleo e Gás', 'periodo' => 1],
                    ['nome' => 'Geologia e Geofísica do Petróleo', 'periodo' => 1],
                    ['nome' => 'Química Aplicada e Físico-Química', 'periodo' => 2],
                    ['nome' => 'Perfuração e Completação de Poços', 'periodo' => 2],
                    ['nome' => 'Processamento e Refino de Petróleo', 'periodo' => 3],
                    ['nome' => 'Segurança, Meio Ambiente e Saúde (SMS)', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'processos fotográficos') => [
                    ['nome' => 'História da Fotografia', 'periodo' => 1],
                    ['nome' => 'Técnica e Equipamentos Fotográficos', 'periodo' => 1],
                    ['nome' => 'Linguagem e Composição Visual', 'periodo' => 2],
                    ['nome' => 'Iluminação e Fotografia de Estúdio', 'periodo' => 2],
                    ['nome' => 'Tratamento de Imagem Digital', 'periodo' => 3],
                    ['nome' => 'Fotojornalismo e Fotografia documental', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'contabilidade') => [
                    ['nome' => 'Introdução à Contabilidade', 'periodo' => 1],
                    ['nome' => 'Matemática Financeira', 'periodo' => 1],
                    ['nome' => 'Contabilidade Comercial e Tributária', 'periodo' => 2],
                    ['nome' => 'Legislação Trabalhista e Previdenciária', 'periodo' => 2],
                    ['nome' => 'Análise das Demonstrações Contábeis', 'periodo' => 3],
                    ['nome' => 'Contabilidade de Custos', 'periodo' => 3],
                ],
                default => [],
            };

            return array_merge($result, $especificas);
        }

        // 2. Cursos Técnicos Subsequentes
        if (str_contains($nomeLower, 'subsequente')) {
            return match (true) {
                str_contains($nomeLower, 'enfermagem') => [
                    ['nome' => 'Anatomia e Fisiologia Humana', 'periodo' => 1],
                    ['nome' => 'Microbiologia e Parasitologia', 'periodo' => 1],
                    ['nome' => 'Fundamentos de Enfermagem', 'periodo' => 1],
                    ['nome' => 'Farmacologia Aplicada', 'periodo' => 2],
                    ['nome' => 'Enfermagem na Saúde da Mulher e da Criança', 'periodo' => 2],
                    ['nome' => 'Enfermagem em Clínica Médica e Cirúrgica', 'periodo' => 3],
                    ['nome' => 'Enfermagem em Urgência e Emergência', 'periodo' => 3],
                    ['nome' => 'Enfermagem em Saúde Pública', 'periodo' => 4],
                    ['nome' => 'Estágio Curricular Supervisional em Enfermagem', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'radiologia') => [
                    ['nome' => 'Anatomia e Fisiologia Humana', 'periodo' => 1],
                    ['nome' => 'Física das Radiações e Radioproteção', 'periodo' => 1],
                    ['nome' => 'Técnicas e Posicionamento Radiográfico I', 'periodo' => 2],
                    ['nome' => 'Processamento de Imagens Médicas', 'periodo' => 2],
                    ['nome' => 'Técnicas e Posicionamento Radiográfico II', 'periodo' => 3],
                    ['nome' => 'Tomografia Computadorizada e Ressonância Magnética', 'periodo' => 3],
                    ['nome' => 'Radiologia Odontológica e Mamografia', 'periodo' => 4],
                    ['nome' => 'Estágio Supervisionado em Radiologia', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'massoterapia') => [
                    ['nome' => 'Anatomia e Fisiologia Humana', 'periodo' => 1],
                    ['nome' => 'Biossegurança e Ergonomia', 'periodo' => 1],
                    ['nome' => 'Técnicas de Massagem Ocidental (Sueca/Relaxante)', 'periodo' => 1],
                    ['nome' => 'Massagem Desportiva e Terapêutica', 'periodo' => 2],
                    ['nome' => 'Técnicas de Massagem Oriental (Shiatsu/Quick Massage)', 'periodo' => 2],
                    ['nome' => 'Drenagem Linfática Manual', 'periodo' => 3],
                    ['nome' => 'Cosmetologia e Ética Profissional', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'saúde bucal') => [
                    ['nome' => 'Anatomia e Fisiologia Bucal', 'periodo' => 1],
                    ['nome' => 'Biossegurança em Odontologia', 'periodo' => 1],
                    ['nome' => 'Materiais Odontológicos', 'periodo' => 2],
                    ['nome' => 'Cariologia e Prevenção em Saúde Bucal', 'periodo' => 2],
                    ['nome' => 'Radiologia Odontológica', 'periodo' => 3],
                    ['nome' => 'Instrumentação e Auxílio Odontológico', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'prótese dentária') => [
                    ['nome' => 'Anatomia e Escultura Dental', 'periodo' => 1],
                    ['nome' => 'Materiais para Prótese Dentária', 'periodo' => 1],
                    ['nome' => 'Prótese Total Removível', 'periodo' => 2],
                    ['nome' => 'Prótese Parcial Removível', 'periodo' => 2],
                    ['nome' => 'Prótese Fixa e Metalurgia', 'periodo' => 3],
                    ['nome' => 'Cerâmica Dental e Estética', 'periodo' => 3],
                    ['nome' => 'Ortodontia Aplicada à Prótese', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'edificações') => [
                    ['nome' => 'Desenho Arquitetônico e CAD', 'periodo' => 1],
                    ['nome' => 'Materiais de Construção Civil', 'periodo' => 1],
                    ['nome' => 'Topografia e Agrimensura', 'periodo' => 2],
                    ['nome' => 'Mecânica dos Solos e Fundações', 'periodo' => 2],
                    ['nome' => 'Instalações Elétricas e Hidrossanitárias', 'periodo' => 3],
                    ['nome' => 'Estruturas de Concreto e Aço', 'periodo' => 3],
                    ['nome' => 'Planejamento, Orçamento e Gestão de Obras', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'eletrotécnica') => [
                    ['nome' => 'Circuitos Elétricos em CA e CC', 'periodo' => 1],
                    ['nome' => 'Desenho Técnico para Eletrotécnica', 'periodo' => 1],
                    ['nome' => 'Medidas Elétricas e Instrumentação', 'periodo' => 2],
                    ['nome' => 'Máquinas e Transformadores Elétricos', 'periodo' => 2],
                    ['nome' => 'Comandos e Automação Industrial', 'periodo' => 3],
                    ['nome' => 'Instalações Elétricas Industriais', 'periodo' => 3],
                    ['nome' => 'Geração, Transmissão e Distribuição de Energia', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'eletromecânica') => [
                    ['nome' => 'Eletricidade Industrial', 'periodo' => 1],
                    ['nome' => 'Desenho Técnico Mecânico', 'periodo' => 1],
                    ['nome' => 'Mecânica Aplicada e Elementos de Máquinas', 'periodo' => 2],
                    ['nome' => 'Comandos Elétricos e CLPs', 'periodo' => 2],
                    ['nome' => 'Sistemas Pneumáticos e Hidráulicos', 'periodo' => 3],
                    ['nome' => 'Manutenção Eletromecânica', 'periodo' => 3],
                    ['nome' => 'Sistemas Automatizados de Produção', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'telecomunicações') => [
                    ['nome' => 'Eletromagnetismo e Linhas de Transmissão', 'periodo' => 1],
                    ['nome' => 'Fundamentos de Telecomunicações', 'periodo' => 1],
                    ['nome' => 'Redes de Dados e Comunicação', 'periodo' => 2],
                    ['nome' => 'Sistemas de Comunicação Óptica (Fibras)', 'periodo' => 2],
                    ['nome' => 'Sistemas de Comunicação Sem Fio (Wireless)', 'periodo' => 3],
                    ['nome' => 'Telefonia IP e Redes NGN', 'periodo' => 3],
                    ['nome' => 'Instalação e Manutenção de Redes de Telecom', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'eventos') => [
                    ['nome' => 'Introdução à Eventologia', 'periodo' => 1],
                    ['nome' => 'Planejamento e Organização de Eventos', 'periodo' => 1],
                    ['nome' => 'Cerimonial, Protocolo e Etiqueta', 'periodo' => 2],
                    ['nome' => 'Marketing e Captação de Eventos', 'periodo' => 2],
                    ['nome' => 'Logística e Operações de Eventos', 'periodo' => 3],
                    ['nome' => 'Serviços de Alimentos e Bebidas em Eventos', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'áudio e vídeo') => [
                    ['nome' => 'Linguagem Audiovisual', 'periodo' => 1],
                    ['nome' => 'Técnicas de Captação e Edição de Áudio', 'periodo' => 1],
                    ['nome' => 'Roteirização e Direção de Cena', 'periodo' => 2],
                    ['nome' => 'Técnicas de Câmera e Iluminação', 'periodo' => 2],
                    ['nome' => 'Edição e Pós-produção de Vídeo', 'periodo' => 3],
                    ['nome' => 'Finalização Audiovisual e Masterização', 'periodo' => 3],
                ],
                str_contains($nomeLower, 'condomínio') => [
                    ['nome' => 'Introdução à Gestão Condominial', 'periodo' => 1],
                    ['nome' => 'Direito Imobiliário e Legislação de Condomínios', 'periodo' => 1],
                    ['nome' => 'Gestão Financeira e Contabilidade Condominial', 'periodo' => 2],
                    ['nome' => 'Manutenção Predial e Segurança', 'periodo' => 2],
                    ['nome' => 'Relações Interpessoais e Resolução de Conflitos', 'periodo' => 3],
                ],
                default => [
                    ['nome' => 'Metodologia de Pesquisa', 'periodo' => 1],
                    ['nome' => 'Informática Aplicada', 'periodo' => 1],
                    ['nome' => 'Ética e Cidadania', 'periodo' => 2],
                    ['nome' => 'Projeto Integrador', 'periodo' => 2],
                ],
            };
        }

        // 3. Cursos de Graduação / Ensino Superior
        if (str_contains($nomeLower, 'bacharelado') || str_contains($nomeLower, 'licenciatura') || str_contains($nomeLower, 'tecnologia')) {
            return match (true) {
                str_contains($nomeLower, 'ciências contábeis') => [
                    ['nome' => 'Introdução à Contabilidade', 'periodo' => 1],
                    ['nome' => 'Matemática Financeira', 'periodo' => 1],
                    ['nome' => 'Teoria da Contabilidade', 'periodo' => 2],
                    ['nome' => 'Contabilidade Financeira e Intermediária', 'periodo' => 2],
                    ['nome' => 'Contabilidade de Custos', 'periodo' => 3],
                    ['nome' => 'Direito Tributário e Legislação Fiscal', 'periodo' => 3],
                    ['nome' => 'Análise das Demonstrações Financeiras', 'periodo' => 4],
                    ['nome' => 'Contabilidade Gerencial', 'periodo' => 4],
                    ['nome' => 'Auditoria Contábil', 'periodo' => 5],
                    ['nome' => 'Perícia Contábil e Arbitragem', 'periodo' => 6],
                    ['nome' => 'Controladoria e Governança', 'periodo' => 7],
                    ['nome' => 'Trabalho de Conclusão de Curso (TCC)', 'periodo' => 8],
                ],
                str_contains($nomeLower, 'educação física') => [
                    ['nome' => 'Anatomia Humana Aplicada', 'periodo' => 1],
                    ['nome' => 'História e Filosofia da Educação Física', 'periodo' => 1],
                    ['nome' => 'Fisiologia do Exercício', 'periodo' => 2],
                    ['nome' => 'Cinesiolgia e Biomecânica', 'periodo' => 2],
                    ['nome' => 'Didática Geral e Pedagogia do Esporte', 'periodo' => 3],
                    ['nome' => 'Metodologia do Ensino de Esportes Coletivos', 'periodo' => 4],
                    ['nome' => 'Educação Física Inclusiva e Adaptada', 'periodo' => 5],
                    ['nome' => 'Estágio Supervisionado na Educação Básica I', 'periodo' => 6],
                    ['nome' => 'Estágio Supervisionado na Educação Básica II', 'periodo' => 7],
                    ['nome' => 'TCC em Educação Física', 'periodo' => 8],
                ],
                str_contains($nomeLower, 'pedagogia') => [
                    ['nome' => 'História e Filosofia da Educação', 'periodo' => 1],
                    ['nome' => 'Psicologia do Desenvolvimento e da Aprendizagem', 'periodo' => 1],
                    ['nome' => 'Sociologia da Educação', 'periodo' => 2],
                    ['nome' => 'Didática e Organização do Trabalho Pedagógico', 'periodo' => 2],
                    ['nome' => 'Alfabetização e Letramento', 'periodo' => 3],
                    ['nome' => 'Fundamentos da Educação Infantil', 'periodo' => 3],
                    ['nome' => 'Gestão Escolar e Coordenação Pedagógica', 'periodo' => 4],
                    ['nome' => 'Educação Especial e Inclusão escolar', 'periodo' => 5],
                    ['nome' => 'Estágio Supervisionado na Educação Infantil', 'periodo' => 6],
                    ['nome' => 'Estágio Supervisionado nos Anos Iniciais', 'periodo' => 7],
                    ['nome' => 'Trabalho de Conclusão de Curso (TCC)', 'periodo' => 8],
                ],
                str_contains($nomeLower, 'gestão pública') => [
                    ['nome' => 'Estado, Sociedade e Administração Pública', 'periodo' => 1],
                    ['nome' => 'Direito Constitucional e Administrativo', 'periodo' => 1],
                    ['nome' => 'Licitações, Contratos e Convenios Públicos', 'periodo' => 2],
                    ['nome' => 'Elaboração e Avaliação de Projetos Públicos', 'periodo' => 2],
                    ['nome' => 'Finanças Públicas e Orçamento (LOA, LDO, PPA)', 'periodo' => 3],
                    ['nome' => 'Gestão de Políticas Públicas', 'periodo' => 3],
                    ['nome' => 'Auditoria, Controle e Transparência no Setor Público', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'processos gerenciais') => [
                    ['nome' => 'Fundamentos da Administração e Organização', 'periodo' => 1],
                    ['nome' => 'Contabilidade e Gestão de Custos', 'periodo' => 1],
                    ['nome' => 'Gestão de Pessoas e Comportamento Organizacional', 'periodo' => 2],
                    ['nome' => 'Marketing e Estratégia de Mercado', 'periodo' => 2],
                    ['nome' => 'Gestão Financeira e Orçamentária', 'periodo' => 3],
                    ['nome' => 'Gestão da Produção e Operações', 'periodo' => 3],
                    ['nome' => 'Planejamento Estratégico e Modelos de Negócios', 'periodo' => 4],
                ],
                str_contains($nomeLower, 'secretariado') => [
                    ['nome' => 'Técnicas de Secretariado e Gestão do Tempo', 'periodo' => 1],
                    ['nome' => 'Redação Empresarial e Oficial', 'periodo' => 1],
                    ['nome' => 'Comunicação Organizacional', 'periodo' => 2],
                    ['nome' => 'Gestão de Documentos e Arquivística', 'periodo' => 2],
                    ['nome' => 'Cerimonial, Protocolo e Etiqueta Corporativa', 'periodo' => 3],
                    ['nome' => 'Língua Inglesa Aplicada ao Secretariado', 'periodo' => 4],
                    ['nome' => 'Gestão de Eventos e Viagens Corporativas', 'periodo' => 5],
                ],
                str_contains($nomeLower, 'processos escolares') => [
                    ['nome' => 'Introdução aos Processos e Gestão Escolar', 'periodo' => 1],
                    ['nome' => 'Legislação da Educação Brasileira (LDB)', 'periodo' => 1],
                    ['nome' => 'Secretaria Escolar e Escrituração de Alunos', 'periodo' => 2],
                    ['nome' => 'Tecnologias de Informação Aplicadas à Educação', 'periodo' => 2],
                    ['nome' => 'Psicologia e Relações Humanas no Ambiente Escolar', 'periodo' => 3],
                    ['nome' => 'Gestão de Recursos Financeiros e Materiais na Escola', 'periodo' => 4],
                    ['nome' => 'Projeto Integrador em Gestão de Processos Escolares', 'periodo' => 5],
                ],
                str_contains($nomeLower, 'tecnologia em massoterapia') => [
                    ['nome' => 'Anatomofisiologia Humana Aplicada', 'periodo' => 1],
                    ['nome' => 'Patologia Geral e Biossegurança', 'periodo' => 1],
                    ['nome' => 'Técnicas de Massagem Ocidentais', 'periodo' => 2],
                    ['nome' => 'Técnicas de Massagem Orientais (Shiatsu / Tui Ná)', 'periodo' => 3],
                    ['nome' => 'Drenagem Linfática Manual Terapêutica', 'periodo' => 4],
                    ['nome' => 'Cosmetologia e Terapias Complementares', 'periodo' => 5],
                    ['nome' => 'Gestão de Clínicas, Spas e Empreendedorismo', 'periodo' => 6],
                ],
                default => [
                    ['nome' => 'Metodologia Científica e de Pesquisa', 'periodo' => 1],
                    ['nome' => 'Informática Aplicada', 'periodo' => 1],
                    ['nome' => 'Ética Profissional e Cidadania', 'periodo' => 2],
                    ['nome' => 'Empreendedorismo e Inovação', 'periodo' => 2],
                ],
            };
        }

        return [];
    }

    /**
     * Gera disciplinas da Formação Geral Básica (BNCC) para os cursos Integrados.
     */
    private function getDisciplinasBNCC(int $maxPeriodos): array
    {
        $materiasBNCC = [
            ['nome' => 'Língua Portuguesa', 'maxP' => 3],
            ['nome' => 'Matemática', 'maxP' => 3],
            ['nome' => 'Física', 'maxP' => 3],
            ['nome' => 'Química', 'maxP' => 3],
            ['nome' => 'Biologia', 'maxP' => 3],
            ['nome' => 'História', 'maxP' => 3],
            ['nome' => 'Geografia', 'maxP' => 3],
            ['nome' => 'Filosofia', 'maxP' => 2],
            ['nome' => 'Sociologia', 'maxP' => 2],
            ['nome' => 'Educação Física', 'maxP' => 3],
            ['nome' => 'Inglês', 'maxP' => 2],
            ['nome' => 'Espanhol', 'maxP' => 2],
            ['nome' => 'Artes', 'maxP' => 1],
        ];

        $disciplinas = [];

        foreach ($materiasBNCC as $materia) {
            $limiteP = min($materia['maxP'], $maxPeriodos);
            for ($p = 1; $p <= $limiteP; $p++) {
                $disciplinas[] = [
                    'nome' => $materia['nome'] . ($limiteP > 1 ? ' ' . $this->numberToRoman($p) : ''),
                    'periodo' => $p,
                ];
            }
        }

        return $disciplinas;
    }
}
