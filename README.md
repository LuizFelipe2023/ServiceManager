# 🧰 Sistema de Gestão de Ordens de Serviço

Sistema web desenvolvido com [Laravel](https://laravel.com/) e [FilamentPHP](https://filamentphp.com/) para gerenciar clientes, técnicos, ordens de serviço e usuários, com exportação em PDF e Excel.

## 📌 Funcionalidades

- 👥 Cadastro e gerenciamento de **clientes**, **técnicos** e **usuários**
- 📝 Criação e acompanhamento de **ordens de serviço**
- 🔐 Controle de acesso por **perfis de usuário** (admin, gerente, etc.)
- 📄 Exportação de dados em **PDF** e **Excel**
- 📊 Interface administrativa moderna com **FilamentPHP**
- 🔎 Filtros, buscas e paginação automáticas

## 💻 Tecnologias Utilizadas

- PHP 8.2+
- Laravel 10+
- FilamentPHP
- Livewire
- TailwindCSS
- Spatie Laravel-Permission (se utilizado para controle de roles)
- Laravel Excel (Maatwebsite)
- DomPDF

## 🚀 Como executar o projeto

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio

# Instale as dependências
composer install
npm install && npm run build

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Configure o banco de dados no .env e rode as migrations
php artisan migrate --seed

# Rode o servidor local
php artisan serve
