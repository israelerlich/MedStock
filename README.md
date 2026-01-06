🏥 MedStock — Gestão de Estoque Médico
O MedStock é um ecossistema robusto para o controle de suprimentos médicos, integrando a gestão de unidades hospitalares, fornecedores e rastreabilidade total de movimentações.

🚀 Setup
Independentemente do seu ambiente (Herd, Laragon ou Docker), o fluxo base é o mesmo:
```
git clone https://github.com/seu-usuario/medstock.git
cd medstock
composer setup
```

2. Configurando o Banco
   ```
   type nul > database/database.sqlite
   php artisan migrate --seed
   ```

3. Execute
```
composer dev
```

🐳 Suporte ao Docker (Sail)
```
#iniciar o container
./vendor/bin/sail up -d

#migrar dentro do container
./vendor/bin/sail artisan migrate
```



