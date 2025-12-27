# Auto Container Labels

Automatically add container labels to newly-created servers using configurable templates.

## Overview

This plugin lets admins define key/value templates that are applied as container labels when new servers are created. Templates support simple variables which get substituted from the server record.

## Installation

Drop the plugin into your Panel plugins folder and follow your Panel's standard plugin install process.

## Filament UI

Open the Admin panel and go to **Container Label Templates**. Create templates with:
- `key` — the label key applied to the container (e.g. `homepage.description`).
- `value` — a template string using variables like `${alias}`.

The form provides a short help text with supported variables.