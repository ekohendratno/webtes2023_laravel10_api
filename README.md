# webtes2023_laravel10_api

Requirment
<ul>
<li>PHP 8.x</li>
<li>Laravel 10.x</li>
<li>MySQL</li>
</ul>
 
Step Instalation
<ul>
<li>Clone "git clone https://github.com/ekohendratno/webtes2023_laravel10_api.git"</li>
<li>Copy .env.example to .env</li>
<li>Config your data .env host,user,pass and dbname
<p>
DB_CONNECTION=mysql<br/><br/>
DB_HOST=127.0.0.1<br/><br/>
DB_PORT=3306<br/>
DB_DATABASE=folarium_tes_crud<br/>
DB_USERNAME=root<br/>
DB_PASSWORD=
</p>
</li>
<li>php artisan migrate</li>
<li>php artisan make:seeder DataPegawaiSeeders</li>
<li>php artisan db:seed DataPegawaiSeeders</li>
<li>php artisan serve</li>
<li>open browser http://localhost:8000</li>
</ul>

Keterangan API

# /api/pegawai

GET /api/pegawai

```


  "success": true,
  "message": "List Data",
  "data": {
    "current_page": 1,
    "data": [
      {
        "pegawai_id": 1,
        "pegawai_nama": "John Doe",
        "pegawai_alamat": "Jl. Sudirman No. 123",
        "pegawai_tanggal_lahir": "1990-01-01",
        "created_at": null,
        "updated_at": null
      },
      ....
    ],
    "first_page_url": "http://127.0.0.1:8000/api/pegawai?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api/pegawai?page=1",
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://127.0.0.1:8000/api/pegawai?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api/pegawai",
    "per_page": 10,
    "prev_page_url": null,
    "to": 4,
    "total": 4
  }
}

```

POST /api/pegawai

```
{
    "success":true,
    "message":"Data Berhasil Ditambah!",
    "data":{...}
}
```

GET /api/pegawai/{pegawai_id}

```
{
  "success": true,
  "message": "Detail Data!",
  "data": {
    "pegawai_id": 1,
    "pegawai_nama": "John Doe",
    "pegawai_alamat": "Jl. Sudirman No. 123",
    "pegawai_tanggal_lahir": "1990-01-01",
    "created_at": null,
    "updated_at": null
  }
}

```

PUT /api/pegawai/{pegawai_id}

```
{
    "success":true,
    "message":"Data Berhasil Diubah!",
    "data":{...}
}
```

DELETE /api/pegawai/{pegawai_id}

```
{
    "success":true,
    "message":"Data Berhasil Dihapus!"
}

```

# /api/jabatan
```
```

# /api/kontrak
```
```
