# Quiz Access Rule: TOTP

[![Moodle Plugin](https://img.shields.io/badge/Moodle-4.5%E2%80%935.0-orange.svg)](https://moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A Moodle quiz access rule plugin that requires students to enter a Time-based One-Time Password (TOTP) before they can start a quiz attempt.

---

## 🇬🇧 English

### Description

The **TOTP Quiz Access Rule** plugin adds an additional security layer to Moodle quizzes by requiring students to enter a valid TOTP code before starting a quiz attempt. This ensures that only students who have access to the current TOTP code (displayed by the teacher during the quiz session) can begin the quiz.

**Key features:**

- ✅ TOTP-based access control for quizzes
- 🔒 Session caching (1 hour) to avoid re-entering the code for multiple attempts
- 🎯 Perfect for supervised exams and in-class assessments
- ✅ Integrates seamlessly with the `local_totp` plugin

### Use Cases

- **In-class quizzes**: Teachers display the TOTP code on the projector, ensuring only students physically present can access the quiz
- **Supervised exams**: Control access to timed assessments during specific sessions
- **Remote proctoring**: Share TOTP codes via secure channels to authorized students

### Requirements

- Moodle 4.5 or higher (supports up to Moodle 5.0)
- PHP 7.4 or higher
- **[local_totp plugin](https://github.com/yourusername/moodle-local_totp)** (required dependency)

### Installation

1. **Install the local_totp plugin first** (required dependency)

   ```bash
   cd /path/to/moodle
   git clone https://github.com/yourusername/moodle-local_totp.git local/totp
   ```

2. **Install this plugin**

   ```bash
   cd /path/to/moodle/mod/quiz/accessrule
   git clone https://github.com/yourusername/moodle-quizaccess_totp.git totp
   ```

3. **Run the Moodle upgrade**

   ```bash
   php admin/cli/upgrade.php --non-interactive
   ```

   Or visit `Site administration > Notifications` in your Moodle site.

4. **Configure the local_totp plugin**
   - Go to `Site administration > Plugins > Local plugins > TOTP Generator`
   - Configure the TOTP settings (secret key, validity window, etc.)

### Usage

#### For Teachers

1. **Enable TOTP in your course**

   - The `local_totp` plugin must be configured for your course
   - Teachers can display the current TOTP code on the course page or via the block

2. **Create or edit a quiz**

   - The TOTP access rule is automatically applied to all quizzes when the `local_totp` plugin is configured
   - No additional configuration is needed in the quiz settings

3. **During the quiz session**
   - Display the current TOTP code to students (on projector, whiteboard, etc.)
   - Students must enter this code before starting their quiz attempt

#### For Students

1. **Starting a quiz**

   - When you click "Attempt quiz now", you'll see a TOTP code entry form
   - Ask your teacher for the current TOTP code
   - Enter the code and submit

2. **Multiple attempts**
   - Once validated, the TOTP check is cached for 1 hour per quiz
   - You won't need to re-enter the code for subsequent attempts within that hour

### Configuration

The plugin works automatically when the `local_totp` plugin is configured. All settings are managed through the `local_totp` plugin:

- **TOTP validity window**: How long each code remains valid (default: 30 seconds)
- **Secret key**: Unique per course, managed by the `local_totp` plugin

### Privacy

This plugin is GDPR-compliant:

- ✅ Does not store any personal data in the database
- ✅ Only uses temporary session data (expires after 1 hour)
- ✅ Includes a privacy provider implementation

### Support

- **Issues**: Report bugs and feature requests on [GitHub Issues](https://github.com/yourusername/moodle-quizaccess_totp/issues)
- **Documentation**: [Moodle Docs](https://docs.moodle.org/)

### License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

### Author

**Loïc CRAMPON**
📅 2025-10-04

---

## 🇫🇷 Français

### Description

Le plugin **Règle d'accès aux quiz TOTP** ajoute une couche de sécurité supplémentaire aux quiz Moodle en obligeant les étudiants à saisir un code TOTP (Time-based One-Time Password) valide avant de commencer une tentative de quiz. Cela garantit que seuls les étudiants ayant accès au code TOTP actuel (affiché par l'enseignant pendant la session de quiz) peuvent commencer le quiz.

**Fonctionnalités principales :**

- ✅ Contrôle d'accès basé sur TOTP pour les quiz
- 🔒 Mise en cache de session (1 heure) pour éviter de ressaisir le code pour plusieurs tentatives
- 🎯 Parfait pour les examens surveillés et les évaluations en classe
- ✅ S'intègre parfaitement avec le plugin `local_totp`

### Cas d'usage

- **Quiz en classe** : Les enseignants affichent le code TOTP au projecteur, garantissant que seuls les étudiants physiquement présents peuvent accéder au quiz
- **Examens surveillés** : Contrôle de l'accès aux évaluations chronométrées pendant des sessions spécifiques
- **Surveillance à distance** : Partage des codes TOTP via des canaux sécurisés aux étudiants autorisés

### Prérequis

- Moodle 4.5 ou supérieur (supporte jusqu'à Moodle 5.0)
- PHP 7.4 ou supérieur
- **[Plugin local_totp](https://github.com/yourusername/moodle-local_totp)** (dépendance obligatoire)

### Installation

1. **Installer d'abord le plugin local_totp** (dépendance requise)

   ```bash
   cd /chemin/vers/moodle
   git clone https://github.com/yourusername/moodle-local_totp.git local/totp
   ```

2. **Installer ce plugin**

   ```bash
   cd /chemin/vers/moodle/mod/quiz/accessrule
   git clone https://github.com/yourusername/moodle-quizaccess_totp.git totp
   ```

3. **Exécuter la mise à jour Moodle**

   ```bash
   php admin/cli/upgrade.php --non-interactive
   ```

   Ou visitez `Administration du site > Notifications` sur votre site Moodle.

4. **Configurer le plugin local_totp**
   - Aller dans `Administration du site > Extensions > Plugins locaux > Générateur TOTP`
   - Configurer les paramètres TOTP (clé secrète, fenêtre de validité, etc.)

### Utilisation

#### Pour les enseignants

1. **Activer TOTP dans votre cours**

   - Le plugin `local_totp` doit être configuré pour votre cours
   - Les enseignants peuvent afficher le code TOTP actuel sur la page du cours ou via un bloc

2. **Créer ou modifier un quiz**

   - La règle d'accès TOTP est automatiquement appliquée à tous les quiz lorsque le plugin `local_totp` est configuré
   - Aucune configuration supplémentaire n'est nécessaire dans les paramètres du quiz

3. **Pendant la session de quiz**
   - Afficher le code TOTP actuel aux étudiants (au projecteur, tableau blanc, etc.)
   - Les étudiants doivent saisir ce code avant de commencer leur tentative de quiz

#### Pour les étudiants

1. **Démarrer un quiz**

   - Lorsque vous cliquez sur "Tenter le quiz maintenant", vous verrez un formulaire de saisie du code TOTP
   - Demandez à votre enseignant le code TOTP actuel
   - Saisissez le code et validez

2. **Tentatives multiples**
   - Une fois validé, la vérification TOTP est mise en cache pour 1 heure par quiz
   - Vous n'aurez pas besoin de ressaisir le code pour les tentatives suivantes dans cette heure

### Configuration

Le plugin fonctionne automatiquement lorsque le plugin `local_totp` est configuré. Tous les paramètres sont gérés via le plugin `local_totp` :

- **Fenêtre de validité TOTP** : Durée de validité de chaque code (par défaut : 30 secondes)
- **Clé secrète** : Unique par cours, gérée par le plugin `local_totp`

### Confidentialité

Ce plugin est conforme au RGPD :

- ✅ Ne stocke aucune donnée personnelle dans la base de données
- ✅ Utilise uniquement des données de session temporaires (expire après 1 heure)
- ✅ Inclut une implémentation du fournisseur de confidentialité

### Support

- **Problèmes** : Signalez les bugs et demandes de fonctionnalités sur [GitHub Issues](https://github.com/yourusername/moodle-quizaccess_totp/issues)
- **Documentation** : [Moodle Docs](https://docs.moodle.org/)

### Licence

Ce programme est un logiciel libre : vous pouvez le redistribuer et/ou le modifier selon les termes de la licence publique générale GNU telle que publiée par la Free Software Foundation, soit la version 3 de la licence, soit (à votre choix) toute version ultérieure.

Ce programme est distribué dans l'espoir qu'il sera utile, mais SANS AUCUNE GARANTIE ; sans même la garantie implicite de QUALITÉ MARCHANDE ou d'ADÉQUATION À UN USAGE PARTICULIER. Consultez la licence publique générale GNU pour plus de détails.

### Auteur

**Loïc CRAMPON**
📅 2025-10-04

---

## Development

### Running Tests

```bash
# Initialize PHPUnit environment (first time only)
php admin/tool/phpunit/cli/init.php

# Run tests
vendor/bin/phpunit --testsuite quizaccess_totp_testsuite
```

### Code Quality

```bash
# Moodle code checker
php admin/cli/check_plugin_syntax.php mod/quiz/accessrule/totp

# PHPCs with Moodle standards
phpcs --standard=moodle mod/quiz/accessrule/totp/
```

### Version Updates

After making changes:

1. Increment `$plugin->version` in `version.php` (format: `YYYYMMDDXX`)
2. Update `$plugin->release` if needed
3. Run `php admin/cli/upgrade.php`

---

**Made with ❤️ for the Moodle community**
