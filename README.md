# 🧰 Sistema de Gestão de Ordens de Serviço

Sistema web desenvolvido com [Laravel](https://laravel.com/) e [FilamentPHP](https://filamentphp.com/) para **gerenciar clientes, técnicos, ordens de serviço e usuários**, com suporte a **exportação de dados em PDF e Excel** e **visualização de gráficos interativos com Chart.js**.

## 📌 Funcionalidades

- 👥 Cadastro e gerenciamento de **clientes**, **técnicos** e **usuários**
- 📝 Criação, edição e acompanhamento de **ordens de serviço**
- 🔐 Controle de acesso baseado em **perfis de usuário** (admin, gerente, etc.)
- 📄 **Exportação de relatórios** em **PDF** e **Excel**
- 📊 **Gráficos dinâmicos** com **Chart.js** para visualização de dados (ordens por status, técnicos mais ativos, etc.)
- 🧭 Painel administrativo com filtros, busca e paginação automática via FilamentPHP

## 💻 Tecnologias Utilizadas

- PHP 8.2+
- Laravel 10+
- FilamentPHP
- Livewire
- TailwindCSS
- Chart.js
- Laravel Excel (Maatwebsite)
- DomPDF
- Spatie Laravel-Permission (se aplicável)

## 🚀 Como executar o projeto

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio

# Instale as dependências do PHP e Node
composer install
npm install && npm run build

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Configure o banco e rode as migrations
php artisan migrate --seed

# Inicie o servidor local
php artisan serve
