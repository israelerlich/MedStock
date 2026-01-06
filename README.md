![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)

🏥 MedStock — Gestão de Estoque Médico
O MedStock é um ecossistema robusto para o controle de suprimentos médicos, integrando a gestão de unidades hospitalares, fornecedores e rastreabilidade total de movimentações.

🚀 Setup
Independentemente do seu ambiente (Herd, Laragon ou Docker), o fluxo base é o mesmo:
```
git clone https://github.com/seu-usuario/medstock.git
cd medstock
```


1.Configure o Projeto
```
composer setup
```


2.(Opcional) Popular com Dados de Teste
```
php artisan db:seed
```


4.Executar
```
composer dev
```
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

🐳 Suporte ao Docker (Sail)

1.Clone e Configure
```
git clone https://github.com/seu-usuario/medstock.git
cd medstock
cp .env.example .env
```


2. Instale as Dependências via Docker
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```


3. Inicie os Containers
```
./vendor/bin/sail up -d
```


4. Configure e Migre
   ```
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate --seed
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run build
  ```
