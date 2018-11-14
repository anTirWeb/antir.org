<?php
if(!(class_exists('Crumina_Attachment_Categories'))){

	class Crumina_Attachment_Categories{

		function __construct() {
			add_action( 'init', array( &$this, 'crum_attachments_category_register' ) );
			add_action('init', array(&$this,'attachment'));
		}

		function crum_attachments_category_register(){
			$labels = array(
				'name'              => _x( 'Attachment Categories', 'taxonomy general name', 'attachment_taxonomies' ),
				'singular_name'     => _x( 'Attachment Category', 'taxonomy singular name', 'attachment_taxonomies' ),
				'search_items'      => __( 'Search Attachment Categories', 'attachment_taxonomies' ),
				'all_items'         => __( 'All Attachment Categories', 'attachment_taxonomies' ),
				'parent_item'       => __( 'Parent Attachment Category', 'attachment_taxonomies' ),
				'parent_item_colon' => __( 'Parent Attachment Category:', 'attachment_taxonomies' ),
				'edit_item'         => __( 'Edit Attachment Category', 'attachment_taxonomies' ),
				'update_item'       => __( 'Update Attachment Category', 'attachment_taxonomies' ),
				'add_new_item'      => __( 'Add New Attachment Category', 'attachment_taxonomies' ),
				'new_item_name'     => __( 'New Attachment Category Name', 'attachment_taxonomies' ),
				'menu_name'         => __( 'Attachment Category', 'attachment_taxonomies' ),
			);

			$args = array(
				'labels'             => $labels,
				'show_admin_column'       => true,
				'hierarchical'       => true,
				'update_count_callback' => '_update_generic_term_count',
				'rewrite'            => array(
					'slug'       => 'attach-cat',
				),
			);

			register_taxonomy( 'attachments_categories', 'attachment', $args );
		}

		function attachment() {
			register_taxonomy_for_object_type('attachments_categories', 'attachment');
		}

	}

}

if(class_exists('Crumina_Attachment_Categories')){
	$Crumina_Attachment_Categories = new Crumina_Attachment_Categories;
}