=== Plugin Name ===
Contributors: dueclic
Donate link: https://www.dueclic.com
Tags: avada, forms, export, leads, database
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily export your Avada Forms data to Excel / CSV .

== Description ==

Avada Forms to Excel / CSV allows you to export forms created with Avada in CSV or Excel in just a few steps.
By simply installing the plugin, it will automatically add a button in Form Entries to esily download data.

### FEATURES

- No configuration is needed
- Export form entries in CSV or Excel
- Easy to use and lightweight plugin
- Use filters to customize columns name and file name

== Languages ==
* English
* Italian

== Installation ==

1. Upload `avadaforms-excel-export.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Now in Avada Forms page you can easily export your data to Excel / CSV

== Frequently Asked Questions ==

= Can I customize field names? =
Yes, for this purpose you can use the filter `avadaforms_export_fieldname`

`

function custom_fieldname($field_label,$form_id){
    // $field_label is the current Label as defined in Avada Form Builder
    // $form_id is the Avada Form ID
    // $field is an object as {id: 'Avada Field ID', field_name: 'Avada Field Name', field_label: 'Avada Field Label as defined in Avada Form Builder'
    return $field_label;
}

add_filter('avadaforms_export_fieldname', 'custom_fieldname',10, 2);
`

= Can I customize field values? =
Yes, for this purpose you can use the filter `avadaforms_export_fieldvalue`

`

function custom_fieldname($field_label,$form_id,$field){
    // $field_label is the current Label as defined in Avada Form Builder
    // $form_id is the Avada Form ID
    // $field is an object as {id: 'Avada Field ID', field_name: 'Avada Field Name', field_label: 'Avada Field Label as defined in Avada Form Builder'
    return $field_label;
}

add_filter('avadaforms_export_fieldname', 'custom_fieldname',10, 3);
`

= Can I customize file name? =
Yes, for this purpose you can use the filter `avadaforms_export_filename`

`

function custom_filename($filename, $form_id){
    // $form_id is the Avada Form ID
    return $filename;
}

add_filter('avadaforms_export_filename', 'custom_filename',10, 2);
`

== Screenshots ==

== Changelog ==

= 1.0 =
* First version released
