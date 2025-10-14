# README – Plateforme Web du Prix National des Micro-entrepreneurs

## 1. Objectif de l’application

L’objectif de cette application web est de digitaliser et centraliser le processus de gestion du **Prix National des Micro-entrepreneurs** organisé par le CMS (Centre de Microfinance Solidaire).
La plateforme permet aux **AMC (Associations de Micro-Crédit)** de soumettre les formulaires de participation des candidats, au **CMS** de superviser et gérer le processus complet, et aux **membres du jury** d’évaluer les candidatures de manière structurée et sécurisée.

---

## 2. Flux de données et rôles utilisateurs

L’application repose sur trois rôles principaux avec des accès et fonctionnalités spécifiques :

### 2.1 Rôle AMC (Association de Micro-Crédit)

*Se connecte → accède au formulaire.
*Remplit les informations du micro-entrepreneur → soumet.
*Les données JSON sont enregistrées en base ET ajoutées automatiquement dans un fichier Excel (ligne horizontale).
*Ce fichier Excel contient toutes les candidatures AMC et peut être téléchargé.

### 2.2 Rôle CMS (Centre de Microfinance Solidaire)

* Supervise la plateforme.
* Dispose d’un tableau de bord complet qui contient des statistiques comme (nombres de total de candidatures deposées par les users AMC, nombre de candidatures présélctionnées (= le nombre de ligne contient le fichier Excel deposé par le centre CMS), membre de jury, nombre de documents notés)
* Gère les comptes AMC (création, suspension, suppression).
* Gère les membres du jury.
* Exporte le fichier Excel qui contient les candidats présélctionnées.
* Récupérer le dossier qui contient tous les documents(sous format pdf) qui ont notés par les membres de jury.

### 2.3 Rôle Membre du Jury

* Se connecte via la page dédiée.
* Dispose d’un tableau de bord.
* Importe les dossiers attribués à évaluer.
* Attribue une **note** à chaque question pour avoir finalement le total des points sur 100 pour chaque candidat selon des critères prédéfinis.
* Envoie les résultats qui sont visibles par le CMS pour le classement final.

### 2.4 Flux de données général

1. L’AMC remplit le formulaire et l’envoie.
2. Le CMS reçoit et valide les dossiers.
3. Une fois validés, les dossiers sont attribués à des membres du jury.
4. Les membres du jury notent les dossiers.
5. Le CMS compile les résultats pour le classement final et les statistiques globales.

---

## 3. Interfaces principales (12 au total)

### Partie AMC

1. Tableau de bord AMC

   * Aperçu des candidatures envoyées.
2. Formulaire de participation

   * Formulaire complet pour soumettre un micro-entrepreneur.

### Partie CMS

3. Tableau de bord CMS

   * Vue d’ensemble de l’activité de la plateforme des statistiques simples avec des cartes graphiques représentant les statistiques.
4. Gestion AMC

   * Liste, ajout, modification, suppression et suspension des comptes AMC.
5. Gestion membres du jury

   * Liste, ajout, suppression des membres.
6. Export

   * Exportation des données sous format Excel ou PDF.
7. Import 

   * Importation des documents notés par les membres de jury.

### Partie Membre du Jury

8. Tableau de bord membre du jury

   * Aperçu des documents notés par les membres de jury avec l'option de modification et suppression.
9. Import

   * Téléversement des candidatures présélectionnées.
10. Notation

* Interface pour noter chaque dossier selon les critères fournis.

### Pages d’accès

11. Page de connexion

* Authentification selon le rôle (AMC, CMS ou Jury).

12. Page d’inscription

* Inscription des nouveaux utilisateurs AMC (soumise à validation CMS).

---

## 4. Technologies utilisées

Frontend :

* React.js (Hooks, Context API, React Router)
* Tailwind CSS pour le design
* Axios pour la communication avec le backend
* Recharts pour les graphiques de statistiques

Backend :

* Laravel 10 (API RESTful)
* Sanctum pour l’authentification par token
* Eloquent ORM pour la gestion des modèles
* Laravel Excel pour l’exportation/importation

Base de données :

* MySQL

Autres outils :

* GitHub pour le versioning
* Postman pour le test de l’API
* XAMPP pour le développement local

---

## 5. Architecture du projet

### Option 1 : Architecture React (frontend)

src/
│
├── assets/ (images, icônes)
├── components/ (éléments réutilisables : boutons, champs, cartes)
├── pages/ (interfaces : tableau de bord, formulaire, connexion, etc.)
├── context/ (gestion du contexte global : utilisateur, auth)
├── services/ (fichiers Axios pour la communication avec l’API Laravel)
├── routes/ (routes du frontend)
└── App.jsx

### Option 2 : Architecture Laravel (backend)

app/
│
├── Http/
│   ├── Controllers/ (AMCController, CMSController, JuryController, AuthController)
│   └── Middleware/
├── Models/ (User, AMC, Jury, Formulaire, Note)
├── database/
│   ├── migrations/ (création des tables)
│   ├── seeders/
│   └── factories/
└── routes/
├── api.php
└── web.php

---

## 6. Modèle de base de données (exemple simplifié)

🧍 Table users

Contient tous les comptes de la plateforme (AMC, CMS et Membres de jury).

Champ	Type	Description
id	INT (PK)	Identifiant unique
nom	VARCHAR(100)	Nom complet
email	VARCHAR(150)	Email unique
mot_de_passe	VARCHAR(255)	Mot de passe haché
role	ENUM('amc', 'cms', 'jury')	Rôle de l’utilisateur
telephone	VARCHAR(20)	Optionnel
created_at	TIMESTAMP	Date d’inscription
updated_at	TIMESTAMP	Dernière mise à jour
📝 Table formulaires

Chaque soumission du formulaire par un AMC sera sauvegardée ici (même si le but final est d’écrire les données dans un fichier Excel).

Champ	Type	Description
id	INT (PK)	Identifiant
amc_id	INT (FK → users.id)	L’utilisateur AMC qui a soumis le formulaire
donnees_formulaire	JSON	Données complètes envoyées depuis le formulaire (toutes les sections)
created_at	TIMESTAMP	Date de soumission
fichier_excel	VARCHAR(255)	Chemin ou nom du fichier Excel mis à jour avec ces données

💡 Même si le vrai fichier Excel existe sur le serveur, ce stockage JSON permet de garder une trace de la soumission et de régénérer le fichier Excel en cas de besoin.

📤 Table exports

Lorsqu’un utilisateur CMS fait la présélection manuelle et dépose un nouveau fichier Excel sur la plateforme, il sera stocké ici.

Champ	Type	Description
id	INT (PK)	Identifiant
cms_id	INT (FK → users.id)	CMS responsable
fichier_nom	VARCHAR(255)	Nom du fichier Excel déposé
fichier_url	VARCHAR(255)	Lien de téléchargement du fichier
type_export	ENUM('preselection')	Type d’exportation (ici toujours présélection)
created_at	TIMESTAMP	Date de dépôt

🧩 Ces fichiers sont ensuite consultés par les membres du jury pour analyse.

📥 Table imports

Quand un membre du jury récupère un fichier Excel déposé par le CMS (les candidatures présélectionnées), cette action est enregistrée ici.

Champ	Type	Description
id	INT (PK)	Identifiant
jury_id	INT (FK → users.id)	Membre du jury
fichier_nom	VARCHAR(255)	Nom du fichier récupéré
fichier_url	VARCHAR(255)	Lien du fichier téléchargé
date_import	TIMESTAMP	Date de récupération
🧾 Table notations

Quand le membre du jury remplit la fiche de notation (avec les infos personnelles + les 10 questions notées), ces données sont sauvegardées ici et un fichier PDF est généré automatiquement.

Champ	Type	Description
id	INT (PK)	Identifiant
jury_id	INT (FK → users.id)	Membre du jury
infos_candidat	JSON	Informations personnelles du micro-entrepreneur (nom, activité, ville, etc.)
reponses_notation	JSON	Notes données aux 10 questions
note_totale	FLOAT	Somme ou moyenne des notes
fichier_pdf	VARCHAR(255)	Chemin du fichier PDF généré automatiquement
created_at	TIMESTAMP	Date de notation

💡 Exemple :

{
  "infos_candidat": {
    "nom": "Amina El Fassi",
    "ville": "Tanger",
    "activité": "Pâtisserie artisanale",
    "revenu": 2800
  },
  "reponses_notation": {
    "qualite_du_produit": 8,
    "impact_social": 9,
    "innovation": 7,
    "viabilite": 8,
    "developpement_durable": 6,
    "presentation": 9,
    "gestion_financiere": 7,
    "communication": 8,
    "implication_personnelle": 10,
    "perspectives": 9
  }
}

📦 Table candidatures

Champ	Type	Description
id	BIGINT (PK)	Identifiant unique
amc_id	BIGINT (FK vers users)	L’utilisateur AMC qui a soumis
form_data	JSON	Les 13 sections du formulaire (données du micro-entrepreneur)
created_at	TIMESTAMP	Date de création
updated_at	TIMESTAMP	Dernière modification
status	ENUM('soumis','modifié','exporté')	Statut de la candidature
excel_row	INT (nullable)	Numéro de ligne dans le fichier Excel (facultatif, utile pour suivi)

📊 Table statistiques

Optionnelle mais utile pour la page “Statistiques” du CMS.

Champ	Type	Description
id	INT (PK)	Identifiant
total_amc	INT	Nombre total d’AMC
total_jury	INT	Nombre total de membres du jury
total_formulaires	INT	Formulaires soumis
total_exports	INT	Fichiers présélection déposés
total_notations	INT	Fiches de notation enregistrées
last_update	DATETIME	Dernière mise à jour

---

## 7. Fonctionnalités principales par rôle

AMC :

* Connexion / Déconnexion
* Soumission du formulaire de participation
* Consultation des dossiers
* Modification avant validation CMS

CMS :

* Gestion des comptes AMC
* Gestion des membres du jury
* Validation des formulaires
* Attribution des dossiers
* Exportation des données
* Suivi statistique

Membre du Jury :

* Import des dossiers attribués
* Évaluation et notation des candidats
* Envoi des résultats au CMS

---

## 8. Sécurité et gestion des accès

* Authentification par rôle via token (Laravel Sanctum)
* Protection des routes et redirections selon le rôle utilisateur
* Validation côté backend pour toutes les requêtes
* Hachage des mots de passe (bcrypt)

---

## 9. Déploiement

* Hébergement Backend : serveur Laravel (par exemple sur Render ou VPS)
* Hébergement Frontend : Netlify ou Vercel
* Base de données : MySQL hébergée sur le même serveur ou sur une instance distante (par exemple PlanetScale)
* Fichier .env configuré avec les clés d’API, URL backend et informations de connexion à la base de données

