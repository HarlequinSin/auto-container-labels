<?php

return [
    'name' => 'Name',
    'navigation_label' => 'Container Label Templates',
    'key' => 'Key',
    'eggs' => 'Eggs',
    'all_eggs' => 'All eggs',
    'value' => 'Value',
    'created' => 'Created',
    'egg_scope_help' => 'Leave empty to apply globally, or choose one or more eggs. Egg-specific templates override global templates with the same key.',
    'container_label_variables' => 'Supports: ${uuid}, ${uuid_short}, ${name}, ${alias}, ${description}',
    'global_key_conflict' => 'A global template already uses this key.',
    'egg_key_conflict' => 'Another template already uses this key for one or more selected eggs.',
    'create_template' => 'Create template',
    'delete_selected_templates' => 'Delete selected templates',
    'delete_selected_templates_heading' => 'Delete selected templates?',
    'delete_selected_templates_description' => 'This permanently deletes the selected templates. Labels already applied to servers are not removed.',
];
