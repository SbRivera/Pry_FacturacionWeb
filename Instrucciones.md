# Guia Deployment Laravel con Docker


## 1️⃣ **CLONAR PROYECTO DESDE GITHUB**

### **1.1 Clonar el repositorio**
```bash
# Clonar proyecto
git clone https://github.com/SbRivera/Pry_FacturacionWeb.git
```

### **1.2 Entrar en la carpeta del proyecto**
```bash
cd Pry_FacturacionWeb
```

### **1.3 Actualizar referencias remotas**
```bash
git fetch origin
```

### **1.4 Crear y cambiar a la rama deploy basada en el remoto**
```bash
git checkout -b deploy origin/deploy
```
Esto crea la rama local deploy y la enlaza con la remota origin/deploy

### **1.5 Verificar que estás en la rama correcta**
```bash
git branch
```
Debe aparecer un asterisco * junto a deploy.

### **1.6 Entrar en la carpeta dearchivos**
```bash
cd Pry_FacturacionWeb
```

---

## 2️⃣ **CONFIGURAR ARCHIVO .env**

### **2.1 Crear .env para el servidor**
```bash
# Copiar desde .env.docker (no desde .env.example)
cp .env.docker .env
```
---

## 3️⃣ **CONSTRUIR Y LEVANTAR LA APLICACIÓN**

### **3.1 Construir las imágenes Docker**
```bash
# Construir imágenes desde el Dockerfile
docker compose build --no-cache

# Ver que se construyó correctamente
docker images
```

### **3.2 Levantar todos los servicios**
```bash
# Levantar en segundo plano
docker compose up -d

(Nota: esperar lo suficiente hasta que esten estables los contenedores. El contenedor "facturacion_node si se debe detener")

# Verificar que todos estén corriendo
docker compose ps
```

### **3.3 Configurar Laravel**
```bash
# Generar clave de aplicación
docker compose exec app php artisan key:generate

# Ejecutar migraciones y seeders
docker compose exec app php artisan migrate:fresh --seed

# Crear enlace de storage
docker compose exec app php artisan storage:link

# Optimizar para producción
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

---

## 4️⃣ **VERIFICAR QUE FUNCIONA**

### **4.1 Comprobar servicios**
```bash
# Ver todos los contenedores corriendo
docker compose ps

# Ver logs si hay problemas
docker compose logs app
```

### **4.2 Acceder a la aplicación**
- **Con IP**: `http://IP_DEL_SERVIDOR:8000`
- **Con dominio**: `http://dominio.com:8000`

### **4.3 Usuarios de prueba**
- **Admin**: `admin@empresa.com` / `admin123`
- **Admin**: `admin@facturacion.com` / `admin123`
- **Demo**: `demo@facturacion.com` / `demo123`

---