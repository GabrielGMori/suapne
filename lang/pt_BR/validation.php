<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O campo :attribute deve ser aceito.',
    'accepted_if'          => 'O :attribute deve ser aceito quando :other for :value.',
    'active_url'           => 'O campo :attribute deve ser uma URL válida.',
    'after'                => 'O campo :attribute deve ser uma data posterior a :date.',
    'after_or_equal'       => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O campo :attribute só pode conter letras.',
    'alpha_dash'           => 'O campo :attribute só pode conter letras, números e traços.',
    'alpha_num'            => 'O campo :attribute só pode conter letras e números.',
    'array'                => 'O campo :attribute deve ser uma matriz.',
    'ascii'                => 'O campo :attribute deve conter somente caracteres alfanuméricos.',
    'before'               => 'O campo :attribute deve ser uma data anterior :date.',
    'before_or_equal'      => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo :attribute deve ser entre :min e :max.',
        'file'    => 'O campo :attribute deve ser entre :min e :max kilobytes.',
        'string'  => 'O campo :attribute deve ser entre :min e :max caracteres.',
        'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'can'                  => 'O campo :attribute contém valores não autorizado.',
    'confirmed'            => 'O campo :attribute de confirmação não confere.',
    'contains'             => 'O campo :attribute está faltando um valor obrigatório.',
    'current_password'     => 'A senha está incorreta.',
    'date'                 => 'O campo :attribute deve ser uma data válida.',
    'date_equals'          => 'O campo :attribute deve ser uma data igual a :date.',
    'date_format'          => 'O campo :attribute não corresponde ao formato :format.',
    'decimal'              => 'O campo :attribute deve ter :decimal casas decimais.',
    'declined'             => 'O :attribute deve ser recusado.',
    'declined_if'          => 'O :attribute deve ser recusado quando :other for :value.',
    'different'            => 'Os campos :attribute e :other devem ser diferentes.',
    'digits'               => 'O campo :attribute deve ter :digits dígitos.',
    'digits_between'       => 'O campo :attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo :attribute tem um valor duplicado.',
    'doesnt_end_with'      => 'O campo :attribute não pode terminar com um dos seguintes: :values.',
    'doesnt_start_with'    => 'O :attribute não pode começar com um dos seguintes: :values.',
    'email'                => 'Endereço de e-mail inválido.',
    'ends_with'            => 'O campo :attribute deve terminar com um dos seguintes: :values',
    'enum'                 => 'O :attribute selecionado é inválido.',
    'exists'               => 'O campo :attribute selecionado é inválido.',
    'extensions'           => 'O campo :attribute deve conter uma das seguintes extensões: :values.',
    'file'                 => 'O campo :attribute deve ser um arquivo.',
    'filled'               => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'file'    => 'O campo :attribute deve ser maior que :value kilobytes.',
        'string'  => 'O campo :attribute deve ser maior que :value caracteres.',
        'array'   => 'O campo :attribute deve conter mais de :value itens.',
    ],
    'gte' => [
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'file'    => 'O campo :attribute deve ser maior ou igual a :value kilobytes.',
        'string'  => 'O campo :attribute deve ser maior ou igual a :value caracteres.',
        'array'   => 'O campo :attribute deve conter :value itens ou mais.',
    ],
    'hex_color'            => 'O campo :attribute deve ser uma cor hexadecimal válida.',
    'image'                => 'O arquivo enviado deve ser uma imagem.',
    'in'                   => 'O campo :attribute selecionado é inválido.',
    'in_array'             => 'O campo :attribute não existe em :other.',
    'integer'              => 'O campo :attribute deve ser um número inteiro.',
    'ip'                   => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4'                 => 'O campo :attribute deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json'                 => 'O campo :attribute deve ser uma string JSON válida.',
    'list' => 'O campo :attribute deve ser uma lista.',
    'lowercase' => 'O campo :attribute deve estar em letras minúsculas.',
    'lt' => [
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'file'    => 'O campo :attribute deve ser menor que :value kilobytes.',
        'string'  => 'O campo :attribute deve ser menor que :value caracteres.',
        'array'   => 'O campo :attribute deve conter menos de :value itens.',
    ],
    'lte' => [
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'file'    => 'O campo :attribute deve ser menor ou igual a :value kilobytes.',
        'string'  => 'O campo :attribute deve ser menor ou igual a :value caracteres.',
        'array'   => 'O campo :attribute não deve conter mais que :value itens.',
    ],
    'mac_address' => 'O campo :attribute deve ser um MAC address válido.',
    'max' => [
        'numeric' => 'O campo :attribute não pode ser superior a :max.',
        'file'    => 'O arquivo enviado não pode ser maior que 10 MB.',
        'string'  => 'O campo :attribute não pode ser superior a :max caracteres.',
        'array'   => 'O campo :attribute não pode ter mais do que :max itens.',
    ],
    'max_digits'           => 'O campo :attribute não pode ser superior a :max dígitos',
    'mimes'                => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'file'    => 'O campo :attribute deve ter pelo menos :min kilobytes.',
        'string'  => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'array'   => 'O campo :attribute deve ter pelo menos :min itens.',
    ],
    'missing'              => 'O campo :attribute deve estar ausente.',
    'missing_if'           => 'O campo :attribute deve estar ausente quando :other for :value.',
    'missing_unless'       => 'O campo :attribute deve estar ausente, a menos que :other seja :value.',
    'missing_with'         => 'O campo :attribute não deve estar presente quando houver :values.',
    'missing_with_all'     => 'O campo :attribute deve estar ausente quando :values estiverem presentes.',
    'min_digits'           => 'O campo :attribute deve ter pelo menos :min dígitos',
    'not_in'               => 'O campo :attribute selecionado é inválido.',
    'multiple_of'          => 'O campo :attribute deve ser um múltiplo de :value.',
    'not_regex'            => 'O campo :attribute possui um formato inválido.',
    'numeric'              => 'O campo :attribute deve ser um número.',
    'password' => [
        'letters'          => 'O campo :attribute deve conter pelo menos uma letra.',
        'mixed'            => 'O campo :attribute deve conter pelo menos uma letra maiúscula e uma letra minúscula.',
        'numbers'          => 'O campo :attribute deve conter pelo menos um número.',
        'symbols'          => 'O campo :attribute deve conter pelo menos um símbolo.',
        'uncompromised'    => 'A senha que você inseriu em :attribute está em um vazamento de dados.'
            . ' Por favor escolha uma senha diferente.',
    ],
    'present'              => 'O campo :attribute deve estar presente.',
    'present_if'           => 'O campo :attribute deve estar presente quando :other for :value.',
    'present_unless'       => 'O campo :attribute deve estar presente, a menos que :other seja :value.',
    'present_with'         => 'O campo :attribute deve estar presente quando :values estiver presente.',
    'present_with_all'     => 'O campo :attribute deve estar presente quando :values estiverem presentes.',
    'regex'                => 'O campo :attribute tem um formato inválido.',
    'required'             => 'Este campo é obrigatório.',
    'required_array_keys'  => 'O campo :attribute deve conter entradas para: :values.',
    'required_if'          => 'Este campo é obrigatório',
    'required_if_accepted' => 'Este campo é obrigatório',
    'required_if_declined' => 'Este campo é obrigatório',
    'required_unless'      => 'Este campo é obrigatório',
    'required_with'        => 'Este campo é obrigatório',
    'required_with_all'    => 'Este campo é obrigatório',
    'required_without'     => 'Este campo é obrigatório',
    'required_without_all' => 'Este campo é obrigatório',
    'prohibited'           => 'O campo :attribute é proibido.',
    'prohibited_if'        => 'O campo :attribute é proibido quando :other for :value.',
    'prohibited_unless'    => 'O campo :attribute é proibido exceto quando :other for :values.',
    'prohibits'            => 'O campo :attribute proíbe :other de estar presente.',
    'same'                 => 'Os campos :attribute e :other devem corresponder.',
    'size'                 => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file'    => 'O campo :attribute deve ter :size kilobytes.',
        'string'  => 'O campo :attribute deve ter :size caracteres.',
        'array'   => 'O campo :attribute deve conter :size itens.',
    ],
    'starts_with'          => 'O campo :attribute deve começar com um dos seguintes valores: :values',
    'string'               => 'O campo :attribute deve ser uma string.',
    'timezone'             => 'O campo :attribute deve ser uma zona válida.',
    'unique'               => 'Este(a) :attribute já está sendo utilizado.',
    'uploaded'             => 'Ocorreu uma falha no upload do arquivo',
    'uppercase'            => 'O campo :attribute deve conter letras maiúsculas.',
    'url'                  => 'O campo :attribute tem um formato inválido.',
    'ulid'                 => 'O campo :attribute deve ser um ULID válido.',
    'uuid'                 => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'address'   => 'endereço',
        'age'       => 'idade',
        'body'      => 'conteúdo',
        'cell'      => 'célula',
        'city'      => 'cidade',
        'country'   => 'país',
        'date'      => 'data',
        'day'       => 'dia',
        'excerpt'   => 'resumo',
        'first_name' => 'primeiro nome',
        'gender'    => 'gênero',
        'marital_status' => 'estado civil',
        'profession' => 'profissão',
        'nationality' => 'nacionalidade',
        'hour'      => 'hora',
        'last_name' => 'sobrenome',
        'message'   => 'mensagem',
        'minute'    => 'minuto',
        'mobile'    => 'celular',
        'month'     => 'mês',
        'name'      => 'nome',
        'zipcode'   => 'cep',
        'company_name'   => 'razão social',
        'neighborhood' => 'bairro',
        'number'    => 'número',
        'password'  => 'senha',
        'phone'     => 'telefone',
        'second'    => 'segundo',
        'sex'       => 'sexo',
        'state'     => 'estado',
        'street'    => 'rua',
        'subject'   => 'assunto',
        'text'      => 'texto',
        'time'      => 'hora',
        'title'     => 'título',
        'username'  => 'usuário',
        'year'      => 'ano',
        'description' => 'descrição',
        'password_confirmation' => 'confirmação da senha',
        'current_password' => 'senha atual',
        'complement' => 'complemento',
        'modality' => 'modalidade',
        'category' => 'categoria',
        'blood_type' => 'tipo sanguíneo',
        'birth_date' => 'data de nascimento',
        'photo' => 'imagem',
        'cpf' => 'CPF',
        'matricula' => 'matrícula',
        'ingresso_ano' => 'ano de ingresso',
        'ingresso_periodo' => 'período de ingresso',
        'periodo' => 'período atual do curso',
        'email_pessoal' => 'e-mail pessoal',
        'email_academico' => 'e-mail acadêmico',
        'data_nascimento' => 'data de nascimento',
        'telefone' => 'telefone do estudante',
        'necessidades' => 'necessidades',
        'situacao' => 'situação',
        'sexo' => 'sexo',
        'etnia' => 'etnia',
        'nacionalidade' => 'nacionalidade',
        'naturalidade' => 'naturalidade',
        'nome_pai' => 'nome do pai',
        'telefone_pai' => 'telefone do pai',
        'nome_mae' => 'nome da mãe',
        'telefone_mae' => 'telefone da mãe',
        'nome_responsavel' => 'nome do responsável',
        'telefone_responsavel' => 'telefone do responsável',
        'email_responsavel' => 'e-mail do responsável',
        'avatar' => 'avatar',
        'curso_id' => 'curso',
        'observacoes' => 'observações',
        'observacao' => 'observação',
        'periodo_inicio' => 'data inicial',
        'periodo_fim' => 'data final',
        'curso_periodo' => 'período no curso'
    ],

];
