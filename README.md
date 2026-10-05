# SUAPNE - Sistema Unificado para Atendimento a Pessoas com Necessidades Especiais

Sistema para a organização dos dados, documentos, planos de trabalho e atendimentos semanais dos estudantes que necessitam de acompanhamento da CNAPNE para o Instituto Federal do Paraná campus Curitiba.

## Setup

As instruções a seguir englobam tudo que é necessário para preparar e executar a aplicação.

Utilize o sistema operacional Windows 10 ou 11.

### Requisitos

- PHP ≥ v8.2.12
- Composer ≥ v2.9.4
- Node.js ≥ v25.2.1
- NPM ≥ v11.6.2
- MySQL ≥ v9.5

> ⚠️ **AVISO**
> 
> A extensão **GD** do PHP precisa estar habilitada. Sem ela, a geração de PDFs com imagens falha e o `composer install` pode reclamar de `ext-gd` ausente.
> 
> Para verificar, execute: `php -m | findstr /I /X gd`.
> 
> Se não aparecer nada, abra o `php.ini` (o caminho aparece usando: `php --ini`), remova o `;` do início da linha `;extension=gd` para que fique `extension=gd`, salve o arquivo e reinicie o terminal e o servidor.

## Instalador

Após instalar os requisitos acima, você pode executar o arquivo `QuickSetup.bat` na raiz do projeto para instalar as dependências, preparar o ambiente e iniciar a aplicação.

## Instalação Manual

Caso você deseje realizar o processo manualmente, siga as instruções abaixo.

### Preparar ambiente

Abra um terminal e execute os comandos na raiz do projeto:

```bash
composer install # Instala dependências do Composer
npm install # Instala dependências do NPM
copy .env.example .env # Copia variáveis de ambiente
php artisan key:generate # Gera uma nova APP_KEY do .env da aplicação
php artisan storage:link # Cria symlink de 'storage/app/public' para 'public/storage'
```

Inicie o servidor MySQL e modifique suas credenciais no arquivo `.env` caso necessário.

Primeiro, crie a database. Você pode fazer isso com o seguinte comando, modificando as variáveis entre "<>", mas apenas caso o `mysql.exe` (normalmente em `C:\Program Files\MySQL\MySQL Server 9.5\bin`) esteja em seu PATH:

```bash
mysql -u <DB_USERNAME> -p<DB_PASSWORD> -e "CREATE DATABASE IF NOT EXISTS suapne_db;"
```

Ou manualmente com um gerenciador de banco de dados, como o MySQL Workbench ou o phpMyAdmin:

```sql
CREATE DATABASE IF NOT EXISTS suapne_db; # Cria a database com nome igual a DB_DATABASE
```

Depois, execute:

```bash
php artisan migrate:fresh --seed # Realiza as migrations e cria usuário primário
```

- E-mail do usuário primário: admin@exemplo.com
- Senha do usuário primário: 123

### Iniciar Aplicação

Abra um terminal e execute os comandos na raíz do projeto:

```bash
composer dev
```

A aplicação deve abrir em `http://localhost:8000` caso o `.env` não tenha sido modificado.

## Equipe

- Edwin Neftaly Jimenez Luis
- Gabriel Gimenez Mori
- Julio Tenchena Gonçalves

## Orientadores

- Fábio Luiz Pessoa Albini
- Elisangela Rambo Sibaldeli da Fonseca
