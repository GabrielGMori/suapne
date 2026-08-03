# SUAPNE - Sistema Unificado para Atendimento às Pessoas com Necessidades Especiais
Sistema para a organização dos dados, documentos, planos de trabalho e atendimentos semanais dos estudantes que necessitam de acompanhamento da CNAPNE para o Instituto Federal do Paraná campus Curitiba.

# Quick Start

As instruções a seguir englobam tudo que é necessário para preparar e executar a aplicação.

Utilize o sistema operacional Windows 10 ou 11.

## Instalador

Você pode executar o arquivo `QuickSetup.bat` na raíz do projeto para instalar automaticamente todos os requisitos, preparar o ambiente e iniciar a aplicação.

## Instalação Manual

Caso você deseje realizar o processo manualmente, abaixo estão todas as dependências necessárias.

### Requisitos

- PHP ≥ v8.2.12
- Composer ≥ v2.9.4
- Node.js ≥ v25.2.1
- NPM ≥ v11.6.2
- MySQL ≥ v9.5

### Preparar ambiente

Abra um terminal e execute os comandos na raíz do projeto:
```
composer install # Instala dependências do Composer
npm install # Instala dependências do NPM
copy .env.example .env # Copia variáveis de ambiente
php artisan key:generate # Gera uma nova APP_KEY do .env da aplicação
php artisan storage:link # Cria symlink de 'storage/app/public' para 'public/storage'
```

Inicie o servidor MySQL e modifique suas credenciais no arquivo `.env` caso necessário. 

Primeiro, crie a database. Você pode fazer isso com o seguinte comando modificando as váriaveis em "<>", mas apenas caso o `mysql.exe` (Normalmente em `C:\Program Files\MySQL\MySQL Server 9.5\bin`) estiver em seu PATH:
```
mysql -u <DB_USERNAME> -p<DB_PASSWORD> -e "CREATE DATABASE suapne_db;" # Cria a database "suapne_db" no servidor MySQL
```
Ou manualmente com um gerenciador de banco de dados, como o MySQL Workbench e PHPMyAdmin:
```
CREATE DATABASE suapne_db # Cria a database no servidor com nome igual a DB_DATABASE
```
Depois, execute:
```
php artisan migrate:fresh --seed # Realiza as migrations e cria usuário primário
```
- E-mail do usuário primário: admin@exemplo.com
- Senha do usuário primário: 123

### Iniciar Aplicação

Abra um terminal e execute os comandos na raíz do projeto:
```
composer dev # Inicia a aplicação em 'http://localhost:8000' (Caso o .env não tenha sido modificado)
```

# Equipe
- Edwin Neftaly Jimenez Luis
- Gabriel Gimenez Mori
- Julio Tenchena Gonçalves

# Coorientadores
- Elisangela Rambo Sibaldeli da Fonseca, servidora da CNAPNE

# Links Importantes
- [Google Drive com documentação](https://drive.google.com/drive/folders/1raF60WLl1aH4Q5BMhY7cYYHMPcu6U23Y?usp=drive_link)
- [Google Docs com ATAs](https://docs.google.com/document/d/1HvxSJwPhb_YCO_2KVSOahKfBtGIS_a5aG190DqAHovw/edit?usp=sharing)
- [Figma com design](https://www.figma.com/design/KA5MYlKpJULiMjrsNZQdfa/Design-Sistema-CNAPNE?node-id=0-1&p=f&t=yB0XE5NhJMugAjN6-0)
