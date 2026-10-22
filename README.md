# Auto Container Labels

Automatically apply configurable container-label templates to servers.

## Overview

This plugin lets admins define global and egg-specific key/value templates. A template may target multiple eggs. Global templates apply to every egg; a matching egg-specific template overrides a global template when both use the same key. Templates support variables substituted from the server record and are applied whenever a server is retrieved.

## Installation

Drop the plugin into your Panel plugins folder and follow your Panel's standard plugin install process.

## Filament UI

Open the Admin panel and go to **Container Label Templates**. Create templates with:
- `key` — the label key applied to the container (e.g. `homepage.description`).
- `eggs` — leave empty to apply globally, or choose one or more eggs to scope the template.
- `value` — a template string using variables like `${alias}`.

The form provides a short help text with supported variables. Use the row edit action to change a template's key, value, or egg assignments. Select rows using the table checkboxes to reveal the bulk-delete action. Deleting a template does not remove labels already applied to servers.