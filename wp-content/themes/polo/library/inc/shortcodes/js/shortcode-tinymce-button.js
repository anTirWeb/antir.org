(function ($) {
	tinymce.PluginManager.add('crumshortcodes', function (editor, url) {
		editor.addButton('crumshortcodes', {
			text: 'Insert shortcode',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text   : 'Dropcap',
					onclick: function () {
						editor.windowManager.open({
							title   : 'Insert Dropcap Shortcode',
							body    : [
								{
									type    : 'listbox',
									name    : 'dropcapStyle',
									label   : 'Style',
									'values': [
										{text: 'Default', value: 'default'},
										{text: 'Colored', value: 'colored'}
									]
								},
								{
									type    : 'listbox',
									name    : 'dropcapShape',
									label   : 'Shape',
									'values': [
										{text: 'Square', value: 'square'},
										{text: 'Circle', value: 'circle'}
									]
								},
								{
									type    : 'listbox',
									name    : 'dropcapSize',
									label   : 'Size',
									'values': [
										{text: 'Normal', value: 'default'},
										{text: 'Small', value: 'small'},
										{text: 'Large', value: 'large'}
									]
								}
							],
							onsubmit: function (e) {
								var selected_text = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[crumina_dropcap style="' + e.data.dropcapStyle + '" shape="' + e.data.dropcapShape + '" size="' + e.data.dropcapSize + '"]' + selected_text + '[/crumina_dropcap]');
							}
						});
					}
				},
                {
                    text   : 'Styled list',
                    onclick: function () {
                        editor.windowManager.open({
                            title   : 'Wrap Ul lists with icons',
                            body    : [
                                {
                                    type : 'textbox',
                                    classes:'crum-icon-add',
                                    name : 'customIcon',
                                    label: 'Icon class'
                                }
                            ],
                            onsubmit: function (e) {
                                var selected_text = tinyMCE.activeEditor.selection.getContent();
                                editor.insertContent('[crumina_styled_list icon="' + e.data.customIcon + '"]' + selected_text + '[/crumina_styled_list]');
                            }
                        });
                    }
                },
				{
					text   : 'Highlight',
					onclick: function () {
						editor.windowManager.open({
							title   : 'Insert Highlight Shortcode',
							body    : [
								{
									type    : 'listbox',
									name    : 'highlightStyle',
									label   : 'Style',
									'values': [
										{text: 'Default', value: 'default'},
										{text: 'Colored', value: 'colored'},
										{text: 'Deleted', value: 'deleted'},
										{text: 'Bootstrap', value: 'bootstrap'}
									]
								},
								{
									type    : 'listbox',
									name    : 'highlightSize',
									label   : 'Size',
									'values': [
										{text: 'Normal', value: 'default'},
										{text: 'Small', value: 'small'},
										{text: 'Large', value: 'large'}
									]
								}
							],
							onsubmit: function (e) {
								var selected_text = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[crumina_text_highlight style="' + e.data.highlightStyle + '" size="' + e.data.highlightSize + '"]' + selected_text + '[/crumina_text_highlight]');
							}
						});
					}
				},
				{
					text   : 'Label',
					onclick: function () {
						editor.windowManager.open({
							title   : 'Insert Label Shortcode',
							body    : [
								{
									type    : 'listbox',
									name    : 'labelStyle',
									label   : 'Style',
									'values': [
										{text: 'Default', value: 'default'},
										{text: 'Primary', value: 'primary'},
										{text: 'Success', value: 'success'},
										{text: 'Info', value: 'info'},
										{text: 'Warning', value: 'warning'},
										{text: 'Danger', value: 'danger'}
									]
								}
							],
							onsubmit: function (e) {
								var selected_text = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[crumina_label style="' + e.data.labelStyle + '" ]' + selected_text + '[/crumina_label]');
							}
						});
					}
				},
				{
					text   : 'Tooltip',
					onclick: function () {
						editor.windowManager.open({
							title   : 'Insert Tooltip Shortcode',
							body    : [
								{
									type    : 'listbox',
									name    : 'align',
									label   : 'Align',
									'values': [
										{text: 'Left', value: 'left'},
										{text: 'Right', value: 'right'},
										{text: 'Top', value: 'top'},
										{text: 'Bottom', value: 'bottom'}
									]
								},
								{
									type : 'textbox',
									name : 'titleTooltip',
									label: 'Title'
								}
							],
							onsubmit: function (e) {
								var selected_text = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[crumina_tooltip align="' + e.data.align + '" title="' + e.data.titleTooltip + '"]' + selected_text + '[/crumina_tooltip]');
							}
						});
					}
				},
				{
					text   : 'Rotated text',
					onclick: function () {
						editor.windowManager.open({
							title   : 'Insert Rotated Text Shortcode',
							body    : [
								{
									type    : 'listbox',
									name    : 'rotatedAnimation',
									label   : 'Animation',
									'values': [
										{text: 'Bounce', value: 'bounce'},
										{text: 'Flash', value: 'flash'},
										{text: 'Pulse', value: 'pulse'},
										{text: 'Rubber Band', value: 'rubberBand'},
										{text: 'Shake', value: 'shake'},
										{text: 'Swing', value: 'swing'},
										{text: 'Tada', value: 'tada'},
										{text: 'Wobble', value: 'wobble'},
										{text: 'BounceIn', value: 'bounceIn'},
										{text: 'FadeIn', value: 'fadeIn'},
										{text: 'Flip', value: 'flip'},
										{text: 'RotateIn', value: 'rotateIn'},
										{text: 'SlideInUp', value: 'slideInUp'},
										{text: 'ZoomIn', value: 'zoomIn'}
									]
								},
								{
									type : 'textbox',
									name : 'rotatedText',
									label: 'Rotated text. Separate words with commas'
								},
								{
									type : 'textbox',
									name : 'rotatedSpeed',
									label: 'Rotation speed in seconds'
								}
							],
							onsubmit: function (e) {
								var selected_text = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[crumina_text_rotator text="' + e.data.rotatedText + '" animation="' + e.data.rotatedAnimation + '" rotate_speed="' + e.data.rotatedSpeed + '"]' + selected_text + '[/crumina_text_rotator]');
							}
						});
					}
				}
			]
		});
	});
})();