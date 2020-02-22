<?php

namespace Sovit;

use Sovit\Helper;

if (!\defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Controls
{
	public static function render($field = [])
	{
		if (empty($field) || empty($field['id'])) {
			return;
		}

		$defaults = [
			'type' => '',
			'attributes' => [],
			'std' => '',
			'desc' => '',
		];

		$field = array_merge($defaults, $field);

		$method_name = $field['type'];

		if (!method_exists(__CLASS__, $method_name)) {
			$method_name = 'text';
		}
		self::$method_name($field);
	}

	private static function checkbox(array $field)
	{
		echo '<label>';
		echo '<input type="checkbox" id="'.esc_attr($field['id']).'" name="'.esc_attr($field['name']).'" value="yes" ';
		checked($field['value'], 'yes');
		echo ' />';
		if (!empty($field['sub_desc'])) {
			echo $field['sub_desc'];
		}
		if (!empty($field['desc'])) {
			echo '<p class="description">';
			echo $field['desc'];
			echo '</p>';
		}
	}

	private static function checkbox_list(array $field)
	{
		if (!\is_array($field['value'])) {
			$field['value'] = [];
		}
		foreach ($field['options'] as $option) {
			echo '<div><label>';
			echo '<input type="checkbox" name="'.esc_attr($field['name']).'[]" value="'.esc_attr($option['value']).'" ';
			checked(\in_array($option['value'], $field['value']));
			echo '/>';
			echo $option['name'];
			echo '</label></div>';
		}
		if (!empty($field['sub_desc'])) {
			echo $field['sub_desc'];
		}
		if (!empty($field['desc'])) {
			echo '<p class="description">';
			echo $field['desc'];
			echo '</p>';
		}
	}

	private static function colorpicker(array $field)
	{
		$attributes = Helper::render_html_attributes($field['attributes']);
		echo '<input type="hidden" id="'.esc_attr($field['id']).'" name="'.esc_attr($field['name']).'" value="'.esc_attr($field['value']).'"/>';
		echo '<span class="wppress-colorpicker" data-value="'.esc_attr($field['value']).'" data-target="'.esc_attr($field['id']).'" data-default="'.$field['std'].'"></span>';
		if (!empty($field['sub_desc'])) {
			echo $field['sub_desc'];
		}
		if (!empty($field['desc'])) {
			echo '<p class="description">';
			echo $field['desc'];
			echo '</p>';
		}
	}

	private static function raw_html(array $field)
	{
		if (empty($field['html'])) {
			return;
		}
		echo '<div id="'.$field['id'].'">';

		echo '<div>'.$field['html'].'</div>';

		echo '</div>';
	}

	private static function select(array $field)
	{
		$attributes = Helper::render_html_attributes($field['attributes']);

		echo '<select name="'.esc_attr($field['name']).'" id="'.$field['id'].'" '.$attributes.'>';
		if (!empty($field['show_select'])) {
			echo '<option value="">— '.esc_html__('Select', 'facebook-events').' —</option>';
		}

		foreach ($field['options'] as $value => $label) {
			echo '<option value="'.esc_attr($value).'" ';
			selected($value, $field['value']);
			echo '>'.$label.'</option>';
		}
		echo '</select>';

		if (!empty($field['sub_desc'])) {
			echo $field['sub_desc'];
		}
		if (!empty($field['desc'])) {
			echo '<p class="description">';
			echo $field['desc'];
			echo '</p>';
		}
	}

	private static function text(array $field)
	{
		if (empty($field['attributes']['class'])) {
			$field['attributes']['class'] = 'regular-text';
		}

		$attributes = Helper::render_html_attributes($field['attributes']);
		echo '<input type="'.esc_attr($field['type']).'" id="'.esc_attr($field['id']).'" name="'.esc_attr($field['name']).'" value="'.esc_attr($field['value']).'" '.$attributes.'/>';

		if (!empty($field['sub_desc'])) {
			echo $field['sub_desc'];
		}
		if (!empty($field['desc'])) {
			echo '<p class="description">';
			echo $field['desc'];
			echo '</p>';
		}
	}
}
