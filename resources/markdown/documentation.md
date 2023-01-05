# Dokumentation

## Wichtige Begriffe

### Das Laravel-Framework

"Laut Chat GPT (OpenAI, 2021), abgerufen am 12.12.2022":  
Laravel ist ein freies, Open-Source PHP-Web-Entwicklungsframework.  
Es wurde von Taylor Otwell entwickelt und zielt darauf ab, Entwicklern beim Erstellen von robusten Anwendungen und Websites zu helfen. 
Laravel bietet verschiedene Funktionen wie Routing, Datenbankabstraktion, Queues, Authentifizierung und Formularvalidierung, die es Entwicklern erleichtern, komplexe Anwendungen zu erstellen.

### VUE 3

"Laut Chat GPT (OpenAI, 2021), abgerufen am 12.12.2022":  
Vue 3 ist die neueste Version des Vue.js JavaScript-Frameworks.  
Es wurde entwickelt, um Entwicklern beim Erstellen von Benutzeroberflächen für Web-Anwendungen zu helfen. 
Im Vergleich zu früheren Versionen bietet Vue 3 verbesserte Leistung und Flexibilität beim Erstellen von Anwendungen. 
Einige der wichtigsten Neuerungen in Vue 3 sind eine verbesserte Komponenten-API, verbesserte Typisierung, Unterstützung für Server-Side-Rendering und eine verbesserte Performance.

### Tailwind CSS
"Laut Chat GPT (OpenAI, 2021), abgerufen am 12.12.2022":  
Tailwind CSS ist ein CSS-Framework, das es Entwicklern erleichtert, eine benutzerdefinierte, responsiv und schnell ladende Benutzeroberfläche für ihre Web-Anwendungen zu erstellen. 
Im Gegensatz zu anderen CSS-Frameworks bietet Tailwind CSS keine vorgefertigten Komponenten oder Design-Systeme, sondern stattdessen eine Sammlung von Utility-Klassen, die Entwicklern ermöglichen, direkt im HTML-Code ihrer Anwendungen zu stylen. 
Dies ermöglicht es Entwicklern, schnell und einfach benutzerdefinierte Designs zu erstellen, ohne dass sie sich um die Implementierung von CSS-Regeln kümmern müssen.

## Der CodingStarter

Diese Anwendung basiert auf der Plattform **CodingStarter**.  
Die Plattform **CodingStarter** ist ein optimaler Einstiegspunkt für die Entwicklung einer Web-Anwendung.

Die Plattform **CodingStarter** besteht aus:
- Laravel 9
- Vue.js 3
- Inertia
- Jetstream
- Tailwind CSS 3
- Homepage
- Anwendung für "Administratoren"
- Anwendung für "Mitarbeiter"
- Anwendung für "Kunden"

### Datenmodell

# Das Datenmodell in der Plattform CodingStarter

Das verwendete Datenmodell besteht aus den folgenden Tabellen:

## administrations
- admin_id

### Verknüpfungen
administrations.admin_id = person_companies.id

## blogs
- id
- blog_author_id
- blog_image_id
- blog_category_id
- blog_date
- title
- slug
- summary
- content
- reading_time
- audio_on
- audio_url
- audio_duration
- markdown_on

## blog_authors
- id
- name
- info

### Verknüpfungen
blog_authors.id = blogs.blog_author_id


## blog_categories
- id
- name

### Verknüpfungen
blog_categories.id = blogs.blog_category_id

## blog_images
- id
- name
- url

### Verknüpfungen
blog_images.id = blogs.blog_image_id

## chats
- id
- chat_type_id
- sender_user_id
- sender_person_company_id
- sender_user_type_id
- receiver_user_id
- receiver_person_company_id
- receiver_user_type_id
- chat_date
- message
- read_status
- read_date
- key_value_one
- key_value_two

## chat_types
- id
- name

## chat_user_types
- id
- name

## companies
- company_id

### Verknüpfungen
companies.company_id = person_companies.id

## countries
- id
- name

## customers
- customer_id

### Verknüpfungen
customers.customer_id = person_companies.id (zugehörige Person/Unternehmen des Anwenders)
customers.customer_id = customers.customer_id (zugehöriges Unternehmen des Anwenders)

### Hinweise
Jeder Kunde (customers) hat einen zugehörigen Datensatz in Person/Unternehmen (person_companies).  
Jeder Kunde (customers) gehört zu einem Unternehmen (companies).  

Bei einer Registrierung von der Homepage wird ein neuer Anwender automatisch zum Unternehmen mit der Id 1.000 zugeordnet. 
Vergleiche hierzu CreateNewUser.php.  


## invitations
- id
- person_company_id
- first_name
- last_name
- email
- application
- role
- uuid
- status

### Verknüpfungen
invitations.person_company_id = person_companies.id (Verweis auf Person / Unternehmen, welche die Einladung ausgesprochen hat)

### Hinweise
Das Attribut **application** hat folgende Wertemenge: 
- Administration
- Unternehmen
- Kunde


## newsletters
- id
- name

## newsletter_members
- id
- newsletter_id
- name
- email
- email_verified_at
- uuid

### Verknüpfungen
newsletter_members.newsletter_id = newsletters.id (Jedes Newslettermitglied (newsletter_members) gehört genau zu einem Newsletter (newsletters))

## person_companies
- id
- person_company_number
- name
- street
- country_id
- postcode
- city
- email
- contactperson_salutation_id
- contactperson_first_name
- contactperson_last_name
- contactperson_phone
- contactperson_email
- billing_address
- billing_adress_line_2
- billing_street
- billing_country_id
- billing_postcode
- billing_city
- is_deleted
- delete_history


## salutations
- id
- name

## users
- first_name
- last_name
- email
- email_verified_at
- password
- two_factor_secret
- two_factor_recovery_codes
- remember_token
- current_team_id
- profile_photo_path
- is_admin
- is_employee
- is_customer
- admin_id
  -  user.admin_id = person_companies.id
- company_id
  - user.company_id = person_companies.id
- customer_id
  - user.customer_id = person_companies.id
- last_login_at

## webinars
- id
- company_id
- webinar_image_id
- title
- decription
- access
- event_date
- event_start
- active

## webinar_images
- id
- name
- url

## webinar_orders
- id
- webinar_id
- salutation_id
- first_name
- last_name
- email
- phone
- history


