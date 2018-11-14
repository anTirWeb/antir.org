<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Vc_Gitem_Acf_Shortcode extends WPBakeryShortCode {
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|void
	 */
	protected function content( $atts, $content = null ) {
		$field_key = $field_key2 = $label = '';
	/**
		 * @var string $el_class
		 * @var string $show_label
		 * @var string $align
		 * @var string $field_group
		 * @var string $show_label
		 * @var string $field_group2
		 */
		extract( shortcode_atts( array(
			'el_class' => '',
			'field_group' => '',
			'show_label' => '',
			'align' => '',
			'show_as_link' => '',
			'field_group2' => '',
		), $atts ) );
		if ( 0 === strlen( $field_group ) ) {
			$groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );
			if ( is_array( $groups ) && isset( $groups[0] ) ) {
				$key = isset( $groups[0]['id'] ) ? 'id' : ( isset( $groups[0]['ID'] ) ? 'ID' : 'id' );
				$field_group = $groups[0][ $key ];
			}
		}
		if ( ! empty( $field_group ) ) {
			$field_key = ! empty( $atts[ 'field_from_' . $field_group ] ) ? $atts[ 'field_from_' . $field_group ] : 'field_from_group_' . $field_group;
		}
		
		if ( 'yes' === $show_label && $field_key ) {
			$field_key .= '_labeled';
		}
		
		$field_group_object = get_field_object($field_key);
		
		if ( $field_group_object && $field_group_object['type'] ) {
		    $field_type = $field_group_object['type'];
		} else {
		    $field_type = "Couldn't get that information";
		}
		
		             
		// Display the value above as a link using the value of the second
		// group/field combination.
		
		if( $atts['show_as_link'] == 'yes' ) {
		    if ( ! empty( $field_group2 ) ) {
			    $field_key2 = ! empty( $atts[ 'field_from_2' . $field_group2 ] ) ? $atts[ 'field_from_2' . $field_group2 ] : 'field_from_group_2' . $field_group2;
		    }
		    
		    $field_group_object2 = get_field_object($field_key2);
		
		    if ( $field_group_object2 && $field_group_object2['type'] ) {
		        $field_type2 = $field_group_object2['type'];
		    } else {
		        $field_type2 = "Couldn't get that information";
		    }
		    
		    
		   $css_class = 'vc_gitem-acf'
		             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
		             . ( strlen( $align ) ? ' vc_gitem-align-' . $align : '' )
		             . ( strlen( $field_key ) ? ' ' . $field_key : '' );    
		  
		    if( $field_type2 == 'email' ) {
		        
		        $ret_str = '<div ' . $field_key . ' class="' 
		        .  esc_attr( $css_class ) . '">'
		        //. 'linked Field type is: ' . $field_type 
		        . ' <a href="mailto:'
		        . '{{ acf' . ( ! empty( $field_key2 ) ? ':' . $field_key2 : '' ) 
		        . ' }}'
		        . '">'
		        . '{{ acf' . ( ! empty( $field_key ) ? ':' . $field_key : '' )
		        . ' }}' 
		        . '</a></div>';
		    
		        return $ret_str;
		    
		    } elseif ( $field_type2 == 'url' )  {

		        $ret_str = '<div ' . $field_key . ' class="' 
		        . esc_attr( $css_class ) . '">'
		        //. 'linked Field type is: ' . $field_type 
		        . ' <a href="'
		        . '{{ acf' . ( ! empty( $field_key2 ) ? ':' . $field_key2 : '' ) 
		        . ' }}'
		        . '" target="_blank">'
		        . '{{ acf' . ( ! empty( $field_key ) ? ':' . $field_key : '' )
		        . ' }}' 
		        . '</a></div>';
		        
		        return $ret_str;
		    } 
		} else {
		
		  	$css_class = 'vc_gitem-acf'
		             . ( strlen( $el_class ) ? ' ' . $el_class : '' )
		             . ( strlen( $align ) ? ' vc_gitem-align-' . $align : '' )
		             . ( strlen( $field_key ) ? ' ' . $field_key : '' );
		    
		    return '<div ' . $field_key . ' class="' . esc_attr( $css_class ) . '">'
		       //. 'Plain Field type is: ' . $field_type 
		       . '{{ acf' . ( ! empty( $field_key ) ? ':' . $field_key : '' ) . ' }}'
		       . '</div>';
		       
		}
		
	

		
	}
}