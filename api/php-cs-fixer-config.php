<?php
// See: https://github.com/FriendsOfPHP/PHP-CS-Fixer
return PhpCsFixer\Config::create()
    ->setRiskyAllowed(false)
    ->setUsingCache(false)
    ->setRules([
        'encoding'                                    => true,
        'elseif'                                      => true,
        'single_quote'                                => true,
        'protected_to_private'                        => true,
        'braces'                                      => true,
        'new_with_braces'                             => true,
        'short_scalar_cast'                           => true,
        'semicolon_after_instruction'                 => true,
        'include'                                     => true,
        'no_short_echo_tag'                           => true,
        'no_useless_return'                           => true,
        'combine_consecutive_unsets'                  => true,
        'no_closing_tag'                              => true,
        'no_unused_imports'                           => true,
        'no_useless_else'                             => true,
        'function_declaration'                        => true,
        'class_definition'                            => true,
        'cast_spaces'                                 => true,
        'no_trailing_whitespace'                      => true,
        'no_trailing_whitespace_in_comment'           => true,
        'no_extra_consecutive_blank_lines'            => true,
        'no_empty_comment'                            => true,
        'no_empty_phpdoc'                             => true,
        'no_leading_import_slash'                     => true,
        'standardize_not_equals'                      => true,
        'declare_equal_normalize'                     => true,
        'no_leading_namespace_whitespace'             => true,
        'object_operator_without_whitespace'          => true,
        'single_blank_line_before_namespace'          => true,
        'ternary_operator_spaces'                     => true,
        'blank_line_after_opening_tag'                => true,
        'no_whitespace_in_blank_line'                 => true,
        'whitespace_after_comma_in_array'             => true,
        'trailing_comma_in_multiline_array'           => true,
        'no_spaces_inside_parenthesis'                => true,
        'no_unneeded_control_parentheses'             => true,
        'no_spaces_after_function_name'               => true,
        'no_spaces_around_offset'                     => true,
        'no_short_bool_cast'                          => true,
        'space_after_semicolon'                       => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_multiline_whitespace_before_semicolons'   => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'switch_case_semicolon_to_colon'              => true,
        'no_trailing_comma_in_list_call'              => true,
        'indentation_type'                            => true,
        'phpdoc_inline_tag'                           => true,
        'phpdoc_no_access'                            => true,
        'phpdoc_trim'                                 => true,
        'phpdoc_indent'                               => true,
        'phpdoc_to_comment'                           => false,
        'phpdoc_order'                                => true,
        'phpdoc_no_empty_return'                      => true,
        'phpdoc_types'                                => true,
        'phpdoc_var_without_name'                     => false,
        'phpdoc_add_missing_param_annotation'         => true,
        'single_line_after_imports'                   => true,
        'single_import_per_statement'                 => true,
        'switch_case_space'                           => true,
        'blank_line_after_namespace'                  => true,
        'blank_line_before_return'                    => true,
        'trim_array_spaces'                           => true,
        'no_blank_lines_after_class_opening'          => true,
        'no_whitespace_before_comma_in_array'         => true,
        'method_separation'                           => true,
        'no_blank_lines_after_phpdoc'                 => true,
        'linebreak_after_opening_tag'                 => true,
        'hash_to_slash_comment'                       => true,
        'lowercase_constants'                         => true,
        'lowercase_keywords'                          => true,
        'lowercase_cast'                              => true,
        'no_empty_statement'                          => true,
        'single_blank_line_at_eof'                    => true,
        'method_argument_space'                       => true,
        'visibility_required'                         => true,
        'phpdoc_no_package'                           => true,
        'phpdoc_scalar'                               => true,
        'phpdoc_single_line_var_spacing'              => true,
        'return_type_declaration'                     => true,
        'function_typehint_space'                     => true,
        'full_opening_tag'                            => true,
        'line_ending'                                 => true,
        'native_function_casing'                      => true,
        'single_class_element_per_statement'          => true,
        'not_operator_with_successor_space'           => true,
        'no_trailing_comma_in_singleline_array'       => true,
        'binary_operator_spaces'                      => ['align_double_arrow' => true, 'align_equals' => false],
        'no_mixed_echo_print'                         => ['use' => 'echo'],
        'concat_space'                                => ['spacing' => 'one'],
        'general_phpdoc_annotation_remove'            => ['author', 'since', 'version', 'group'],
        'array_syntax'                                => ['syntax' => 'short'],
    ])
    ->setFinder(PhpCsFixer\Finder::create()->in('./src'));
