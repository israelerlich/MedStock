# MedStock - Sistema de Gestão de Estoque Médico

Sistema de gestão de estoque desenvolvido em Laravel para controle de produtos médicos, hospitais, fornecedores e movimentações.

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias](#tecnologias)
- [Funcionalidades](#funcionalidades)
- [Requisitos](#requisitos)
- [Instalação com Herd](#instalação-com-herd)
- [Instalação com Laragon](#instalação-com-laragon)
- [Instalação com Docker (Sail)](#instalação-com-docker-sail)
- [Configuração](#configuração)
- [Scripts Disponíveis](#scripts-disponíveis)
- [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
- [Testes](#testes)
- [Contribuindo](#contribuindo)

## 🎯 Sobre o Projeto

MedStock é um sistema completo para gestão de estoque de produtos médicos, permitindo:
- Controle de hospitais e usuários
- Gestão de fornecedores e clientes
- Cadastro e rastreamento de produtos médicos
- Registro de movimentações de estoque (entrada/saída)
- Sistema de logs e auditoria
- Controle de endereços polimórfico

## 🚀 Tecnologias

- **Backend:** PHP 8.2+ / Laravel 12.x
- **Frontend:** Vite + TailwindCSS 4.0
- **Banco de Dados:** SQLite (padrão) / MySQL 8.4
- **Testes:** PestPHP 4.x
- **Ferramentas:** Laravel Tinker, Laravel Pail, Laravel Pint

## ✨ Funcionalidades

- ✅ Autenticação e autorização de usuários (Roles: Admin, Manager, Staff)
- ✅ Gestão de Hospitais com múltiplos usuários
- ✅ Cadastro de Fornecedores e Clientes
- ✅ Controle de Produtos com tipos e status
- ✅ Movimentações de Estoque (Entrada/Saída)
- ✅ Sistema de Logs para auditoria
- ✅ Endereços com relacionamento polimórfico
- ✅ Soft Deletes em todos os modelos principais
- ✅ Factories e Seeders para dados de teste

## 📦 Requisitos

### Requisitos Mínimos

- **PHP:** >= 8.2
- **Composer:** >= 2.0
- **Node.js:** >= 18.x
- **NPM:** >= 9.x

### Extensões PHP Necessárias

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- SQLite (ou MySQL para produção)

---

## 🔧 Instalação com Herd

[Herd](https://herd.laravel.com/) é a maneira mais rápida e simples de configurar um ambiente Laravel no Windows/macOS.

### 1. Instalar o Herd

1. Baixe e instale o Herd: https://herd.laravel.com/
2. Execute o instalador e siga as instruções
3. O Herd irá configurar automaticamente PHP, Nginx e outros serviços necessários

### 2. Clonar o Projeto

```bash
# Clone o repositório na pasta do Herd
cd C:\Users\SEU_USUARIO\Herd
git clone https://github.com/seu-usuario/medstock.git
cd medstock
```

### 3. Configurar o Projeto

```bash
# Instalar dependências do PHP
composer install

# Copiar arquivo de ambiente
copy .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Criar banco de dados SQLite (caso não exista)
type nul > database\database.sqlite

# Executar migrações
php artisan migrate

# (Opcional) Popular banco com dados de teste
php artisan db:seed
```

### 4. Instalar Dependências Frontend

```bash
# Instalar pacotes Node
npm install

# Compilar assets
npm run build
```

### 5. Acessar o Sistema

O Herd automaticamente disponibiliza o site em:
- **URL:** http://medstock.test
- Abra o navegador e acesse a URL acima

### 6. Modo Desenvolvimento (Opcional)

Para desenvolvimento com hot-reload:

```bash
# Terminal 1 - Iniciar servidor de desenvolvimento
composer dev
```

Ou individualmente:

```bash
# Terminal 1
php artisan serve

# Terminal 2
php artisan queue:listen

# Terminal 3
npm run dev
```

---

## 🔧 Instalação com Laragon

[Laragon](https://laragon.org/) é um ambiente de desenvolvimento portável para Windows.

### 1. Instalar o Laragon

1. Baixe o Laragon Full: https://laragon.org/download/
2. Execute o instalador
3. Inicie o Laragon e clique em "Start All"

### 2. Verificar Versões

```bash
# Abrir terminal do Laragon (botão direito no Laragon > Terminal)

# Verificar PHP (deve ser >= 8.2)
php -v

# Verificar Composer
composer -V

# Verificar Node.js
node -v
```

> **Nota:** Se o PHP for inferior a 8.2, você pode baixar versões mais recentes em: https://windows.php.net/download/

### 3. Adicionar PHP 8.2+ ao Laragon (se necessário)

1. Baixe o PHP 8.2 ou superior (Thread Safe): https://windows.php.net/download/
2. Extraia para: `C:\laragon\bin\php\php-8.2.x`
3. No Laragon: Clique com botão direito > PHP > Version > php-8.2.x
4. Reinicie o Laragon

### 4. Clonar o Projeto

```bash
# Navegar para a pasta de projetos do Laragon
cd C:\laragon\www

# Clonar o repositório
git clone https://github.com/seu-usuario/medstock.git
cd medstock
```

### 5. Configurar o Projeto

```bash
# Instalar dependências do PHP
composer install

# Copiar arquivo de ambiente
copy .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 6. Configurar Banco de Dados

#### Opção A: SQLite (Mais Simples)

```bash
# Criar arquivo do banco de dados
type nul > database\database.sqlite
```

No arquivo `.env`, certifique-se de ter:
```env
DB_CONNECTION=sqlite
```

#### Opção B: MySQL (via Laragon)

1. Certifique-se que o MySQL está ativo no Laragon
2. Crie o banco de dados:
   - Clique com botão direito no Laragon > MySQL > MySQL Console
   - Digite a senha (padrão é vazio, apenas pressione Enter)
   - Execute: `CREATE DATABASE medstock;`

3. Configure o `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medstock
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Executar Migrações

```bash
# Executar migrações
php artisan migrate

# (Opcional) Popular banco com dados de teste
php artisan db:seed
```

### 8. Instalar Dependências Frontend

```bash
# Instalar pacotes Node
npm install

# Compilar assets
npm run build
```

### 9. Configurar Virtual Host

#### Método Automático (Recomendado):

1. No Laragon, clique com botão direito > Add Vhost
2. Nome: `medstock.test`
3. Diretório: `C:\laragon\www\medstock\public`
4. Clique em OK
5. Reinicie o Laragon (Botão "Reload")

#### Método Manual:

Edite: `C:\laragon\etc\apache2\sites-enabled\auto.medstock.test.conf`

```apache
<VirtualHost *:80>
    DocumentRoot "C:/laragon/www/medstock/public"
    ServerName medstock.test
    ServerAlias *.medstock.test
    <Directory "C:/laragon/www/medstock/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 10. Acessar o Sistema

- **URL:** http://medstock.test
- Abra o navegador e acesse a URL acima

### 11. Modo Desenvolvimento (Opcional)

```bash
# Usando o script do composer (recomendado)
composer dev
```

Ou abra 3 terminais separados:

```bash
# Terminal 1 - Servidor
php artisan serve --port=8000

# Terminal 2 - Fila
php artisan queue:listen --tries=1

# Terminal 3 - Vite (frontend)
npm run dev
```

---

## 🐳 Instalação com Docker (Sail)

Para quem prefere usar Docker, o projeto inclui suporte ao Laravel Sail.

### 1. Pré-requisitos

- Docker Desktop instalado e em execução
- WSL2 habilitado (Windows)

### 2. Instalação

```bash
# Clonar repositório
git clone https://github.com/seu-usuario/medstock.git
cd medstock

# Instalar dependências (primeira vez)
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Copiar arquivo de ambiente
cp .env.example .env

# Iniciar containers
./vendor/bin/sail up -d

# Gerar chave
./vendor/bin/sail artisan key:generate

# Executar migrações
./vendor/bin/sail artisan migrate

# Instalar dependências frontend
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### 3. Acessar

- **Aplicação:** http://localhost
- **MySQL:** localhost:3306

### 4. Comandos Úteis com Sail

```bash
# Parar containers
./vendor/bin/sail down

# Ver logs
./vendor/bin/sail logs

# Acessar container
./vendor/bin/sail shell

# Executar testes
./vendor/bin/sail test
```

---

## ⚙️ Configuração

### Variáveis de Ambiente Importantes

Edite o arquivo `.env` conforme necessário:

```env
# Aplicação
APP_NAME="MedStock"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://medstock.test

# Banco de Dados SQLite (padrão)
DB_CONNECTION=sqlite

# OU MySQL (se preferir)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=medstock
# DB_USERNAME=root
# DB_PASSWORD=

# Sessão
SESSION_DRIVER=database

# Fila
QUEUE_CONNECTION=database

# Cache
CACHE_STORE=database

# Email (desenvolvimento)
MAIL_MAILER=log
```

### Criar Usuário Admin

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@medstock.com',
    'password' => bcrypt('password'),
    'role' => App\Enums\Role::ADMIN
]);
```

---

## 📝 Scripts Disponíveis

O projeto inclui scripts Composer úteis:

### Setup Completo

```bash
composer setup
```

Executa automaticamente:
- `composer install`
- Copia `.env.example` para `.env` (se não existir)
- `php artisan key:generate`
- `php artisan migrate --force`
- `npm install`
- `npm run build`

### Modo Desenvolvimento

```bash
composer dev
```

Inicia simultaneamente:
- Servidor Laravel (http://localhost:8000)
- Queue listener
- Vite dev server (hot-reload)

### Outros Comandos Úteis

```bash
# Executar migrações
php artisan migrate

# Reverter migrações
php artisan migrate:rollback

# Resetar banco de dados
php artisan migrate:fresh

# Popular banco com dados de teste
php artisan db:seed

# Executar código PHP interativo
php artisan tinker

# Ver logs em tempo real
php artisan pail

# Formatar código (PSR-12)
./vendor/bin/pint
```

---

## 🗃️ Estrutura do Banco de Dados

### Modelos Principais

- **User** - Usuários do sistema com roles (Admin, Manager, Staff)
- **Hospital** - Hospitais cadastrados
- **UserHospital** - Relação usuário-hospital (many-to-many)
- **Supplier** - Fornecedores de produtos
- **Client** - Clientes que recebem produtos
- **Product** - Produtos médicos
- **ProductMovement** - Movimentações de estoque (entrada/saída)
- **Log** - Logs de auditoria do sistema
- **Address** - Endereços (polimórfico - pode pertencer a qualquer modelo)

### Enums

- **Role:** ADMIN, MANAGER, STAFF
- **ActionType:** CREATE, UPDATE, DELETE, READ
- **LogType:** INFO, WARNING, ERROR, SUCCESS
- **MovementType:** ENTRY, EXIT
- **ProductStatus:** ACTIVE, INACTIVE, DISCONTINUED
- **ProductType:** MEDICATION, EQUIPMENT, SUPPLY, INSTRUMENT, CONSUMABLE
- **Profession:** DOCTOR, NURSE, PHARMACIST, TECHNICIAN, ADMINISTRATOR, OTHER
- **Country:** BR, US, UK, FR, DE, ES, IT, CA, AU, JP

### Relacionamentos

```
User ← UserHospital → Hospital
Supplier → Products
Product → ProductMovements
Client → ProductMovements
Address ← (Supplier, Hospital, Client) [Polimórfico]
```

---

## 🧪 Testes

O projeto usa PestPHP para testes.

```bash
# Executar todos os testes
./vendor/bin/pest

# Executar testes com coverage
./vendor/bin/pest --coverage

# Executar testes de uma pasta específica
./vendor/bin/pest tests/Feature

# Executar teste específico
./vendor/bin/pest tests/Feature/ExampleTest.php
```


### Problemas Comuns

#### Erro: "Class 'SQLite3' not found"

**Solução:** Habilite a extensão SQLite no PHP:
1. Abra o arquivo `php.ini`
2. Remova o `;` da linha: `;extension=sqlite3`
3. Reinicie o servidor

#### Erro: "npm command not found"

**Solução:** Instale o Node.js: https://nodejs.org/

#### Erro: "Permission denied" (Linux/Mac)

**Solução:**
```bash
chmod -R 775 storage bootstrap/cache
```

#### Erro de porta já em uso

**Solução:**
```bash
# Usar porta diferente
php artisan serve --port=8001
```

#### Vite não conecta em modo dev

**Solução:** Verifique se a porta 5173 está liberada no firewall

---

