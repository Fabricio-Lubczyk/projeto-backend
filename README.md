# Sistema de Gestão de Eventos

Aplicação web desenvolvida com Laravel para cadastrar, organizar e acompanhar eventos. O sistema utiliza arquitetura MVC, PostgreSQL, autenticação Laravel Breeze, controle de perfis, policies, Form Requests e Eloquent ORM.

## Funcionalidades

- Cadastro e autenticação de usuários.
- Perfis de administrador, organizador e participante.
- CRUD de eventos e categorias.
- Inscrição e cancelamento de inscrições em eventos.
- Controle de vagas e bloqueio de inscrições duplicadas.
- Lista de participantes para o organizador ou administrador.
- Painel com resumo de eventos e inscrições.
- Dados de demonstração para validar os fluxos principais.

## Requisitos

- PHP 8.3 ou superior.
- Composer.
- Node.js e npm.
- PostgreSQL.

## Instalação

Crie um banco PostgreSQL chamado `sistema_eventos`. Depois, na raiz do projeto, execute:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate --seed
```

No arquivo `.env`, informe o usuário e a senha do seu PostgreSQL caso sejam diferentes dos valores padrão:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sistema_eventos
DB_USERNAME=postgres
DB_PASSWORD=
```

Para iniciar a aplicação:

```powershell
php artisan serve
```

Abra `http://127.0.0.1:8000` no navegador.

## Usuários de demonstração

Após executar `php artisan migrate --seed`, use a senha `password` para os acessos abaixo:

| Perfil | E-mail |
| --- | --- |
| Administrador | admin@sistemaeventos.test |
| Organizador | organizador@sistemaeventos.test |
| Participante | participante@sistemaeventos.test |

## Validação

Para executar a suíte automatizada:

```powershell
php artisan test
```

Os testes cobrem autenticação, perfis, CRUD de eventos, validações, inscrições, vagas, cancelamentos e policies.
