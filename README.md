# Projecte Final d'Integració - Izan Ruiz

## Descripció
Aquest projecte consisteix en el desplegament d'una arquitectura web completa utilitzant Docker Compose. L'stack inclou un servidor web Apache amb SSL, base de dades MySQL, cache amb Redis i gestió via phpMyAdmin.

## Instruccions de Desplegament

1.  **Configuració de Hosts:**
    Afegir al fitxer hosts (`C:\Windows\System32\drivers\etc\hosts`):
    ```text
    127.0.0.1 frontend.local
    127.0.0.1 api.local
    ```

2.  **Arrencar l'Stack:**
    ```bash
    docker-compose up -d --build
    ```

3.  **Credencials:**
    *   MySQL/phpMyAdmin: Usuari `izan` / Password `secret`

---

## Evidències del Projecte (Lliurament)

A continuació es mostren les captures de pantalla requerides per a l'avaluació:

### 1. Docker Compose PS (Serveis en execució)
*Captura mostrant tots els serveis actius i els healthchecks superats.*
![Docker Compose PS](capturas/1-docker-ps.png)

### 2. Navegador accedint a https://frontend.local (SSL)
*Accés al Virtual Host segur amb certificat auto-signat, mostrant dades de Redis i MySQL.*
![Frontend SSL](capturas/2-frontend.png)

### 3. phpMyAdmin (Taules de la base de dades)
*Visualització de l'estructura de la base de dades i les taules `users` i `articles`.*
![phpMyAdmin](capturas/3-phpmyadmin.png)

### 4. Output de l'API (JSON)
*Resposta de l'endpoint `/api/articles` retornant les dades en format JSON.*
![API JSON](capturas/4-api-json.png)

### 5. Logs d'Apache
*Registres de peticions del servidor mostrant el format JSON personalitzat.*
![Logs Apache](capturas/5-logs.png)
