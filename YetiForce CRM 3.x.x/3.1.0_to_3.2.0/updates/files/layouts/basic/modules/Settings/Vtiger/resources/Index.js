/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 *************************************************************************************/
jQuery.Class("Settings_Vtiger_Index_Js", {
	showMessage: function (customParams) {
		var params = {};
		params.animation = "show";
		params.type = 'success';
		params.title = app.vtranslate('JS_MESSAGE');

		if (typeof customParams != 'undefined') {
			var params = jQuery.extend(params, customParams);
		}
		Vtiger_Helper_Js.showPnotify(params);
	},
	selectIcon: function () {
		var aDeferred = jQuery.Deferred();
		app.showModalWindow({
			id: 'iconsModal',
			url: 'index.php?module=Vtiger&view=IconsModal&parent=Settings',
			cb: function (container) {
				app.showSelect2ElementView(container.find('#iconsList'), {
					templateSelection: function (data) {
						if (!data.id) {
							return (data.text);
						}
						var type = $(data.element).data('type');
						container.find('.iconName').text(data.id);
						container.find('#iconName').val(data.id);
						container.find('#iconType').val(type);
						if (type == 'icon') {
							container.find('.iconExample').html('<span class="' + data.element.value + '" aria-hidden="true"></span>');
						} else if (type = 'image') {
							container.find('.iconExample').html('<img width="24px" src="' + data.element.value + '"/>')
						}
						return data.text;
					},
					templateResult: function (data) {
						if (!data.id) {
							return (data.text);
						}
						var type = $(data.element).data('type');
						if (type == 'icon') {
							var option = $('<span class="' + data.element.value + '" aria-hidden="true"> - ' + $(data.element).data('class') + '</span>');
						} else if (type = 'image') {
							var option = $('<img width="24px" src="' + data.element.value + '" title="' + data.text + '" /><span> - ' + data.text + '</span>');
						}
						return option;
					},
					closeOnSelect: true
				});
				container.find('[name="saveButton"]').click(function (e) {
					aDeferred.resolve({
						type: container.find('#iconType').val(),
						name: container.find('#iconName').val(),
					});
					app.hideModalWindow(container, 'iconsModal');
				});
			}
		});
		return aDeferred.promise();
	}
}, {
	registerDeleteShortCutEvent: function (shortCutBlock) {
		var thisInstance = this;
		if (typeof shortCutBlock == 'undefined') {
			var shortCutBlock = jQuery('div#settingsShortCutsContainer')
		}
		shortCutBlock.on('click', '.unpin', function (e) {
			var actionEle = jQuery(e.currentTarget);
			var closestBlock = actionEle.closest('.moduleBlock');
			var fieldId = actionEle.data('id');
			var shortcutBlockActionUrl = closestBlock.data('actionurl');
			var actionUrl = shortcutBlockActionUrl + '&pin=false';
			var progressIndicatorElement = jQuery.progressIndicator({
				'blockInfo': {
					'enabled': true
				}
			});
			AppConnector.request(actionUrl).then(function (data) {
				if (data.result.SUCCESS == 'OK') {
					closestBlock.remove();
					thisInstance.registerSettingShortCutAlignmentEvent();
					var menuItemId = '#' + fieldId + '_menuItem';
					var shortCutActionEle = jQuery(menuItemId);
					var imagePath = shortCutActionEle.data('pinimageurl');
					shortCutActionEle.attr('src', imagePath).data('action', 'pin');
					progressIndicatorElement.progressIndicator({
						'mode': 'hide'
					});
					var params = {
						title: app.vtranslate('JS_MESSAGE'),
						text: app.vtranslate('JS_SUCCESSFULLY_UNPINNED'),
						animation: 'show',
						type: 'info'
					};
					thisInstance.registerReAlign();
					Vtiger_Helper_Js.showPnotify(params);
				}
			});
			e.stopPropagation();
		});
	},
	registerPinShortCutEvent: function (element) {
		var thisInstance = this;
		var id = element.data('id');
		var url = 'index.php?module=Vtiger&parent=Settings&action=Basic&mode=updateFieldPinnedStatus&pin=true&fieldid=' + id;
		var progressIndicatorElement = jQuery.progressIndicator({
			'blockInfo': {
				'enabled': true
			}
		});
		AppConnector.request(url).then(function (data) {
			if (data.result.SUCCESS == 'OK') {
				var params = {
					'fieldid': id,
					'mode': 'getSettingsShortCutBlock',
					'module': 'Vtiger',
					'parent': 'Settings',
					'view': 'IndexAjax'
				}
				AppConnector.request(params).then(function (data) {
					var shortCutsMainContainer = jQuery('#settingsShortCutsContainer');
					var existingDivBlock = jQuery('#settingsShortCutsContainer div.row:last');
					var count = jQuery('#settingsShortCutsContainer div.row:last').children("div").length;
					if (count == 3) {

						var newBlock = jQuery('#settingsShortCutsContainer').append('<div class="row">' + data);
					} else {
						var newBlock = jQuery(data).appendTo(existingDivBlock);
					}
					thisInstance.registerSettingShortCutAlignmentEvent();
					progressIndicatorElement.progressIndicator({
						'mode': 'hide'
					});
					var params = {
						text: app.vtranslate('JS_SUCCESSFULLY_PINNED')
					};
					Settings_Vtiger_Index_Js.showMessage(params);
				});
			}
		});
	},
	registerSettingsShortcutClickEvent: function () {
		jQuery('#settingsShortCutsContainer').on('click', '.moduleBlock', function (e) {
			var url = jQuery(e.currentTarget).data('url');
			window.location.href = url;
		});
	},
	registerSettingShortCutAlignmentEvent: function () {
		jQuery('#settingsShortCutsContainer').find('.moduleBlock').removeClass('marginLeftZero');
		jQuery('#settingsShortCutsContainer').find('.moduleBlock:nth-child(3n+1)').addClass('marginLeftZero');
	},
	registerWidgetsEvents: function () {
		var widgets = jQuery('div.widgetContainer');
		widgets.on('shown.bs.collapse', function (e) {
			var widgetContainer = jQuery(e.currentTarget);
			var quickWidgetHeader = widgetContainer.closest('.quickWidget').find('.quickWidgetHeader');
			var imageEle = quickWidgetHeader.find('.imageElement')
			var imagePath = imageEle.data('downimage');
			imageEle.attr('src', imagePath);
		});
		widgets.on('hidden.bs.collapse', function (e) {
			var widgetContainer = jQuery(e.currentTarget);
			var quickWidgetHeader = widgetContainer.closest('.quickWidget').find('.quickWidgetHeader');
			var imageEle = quickWidgetHeader.find('.imageElement')
			var imagePath = imageEle.data('rightimage');
			imageEle.attr('src', imagePath);
		});
	},
	registerAddShortcutDragDropEvent: function () {
		var thisInstance = this;
		var elements = jQuery(".subMenu .menuShortcut a");
		var classes = 'ui-draggable-menuShortcut bg-primary';
		elements.draggable({
			containment: "#page",
			appendTo: "body",
			helper: "clone",
			start: function (e, ui)
			{
				$(ui.helper).addClass(classes);
			},
			zIndex: 99999
		});
		jQuery("#settingsShortCutsContainer").droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			accept: ".subMenu .menuShortcut a",
			drop: function (event, ui) {
				var url = ui.draggable.attr('href');
				var isExist = false;
				jQuery('#settingsShortCutsContainer [id^="shortcut"]').each(function () {
					var shortCutUrl = jQuery(this).data('url');
					if (shortCutUrl == url) {
						isExist = true;
						return;
					}
				})
				if (isExist) {
					var params = {
						title: app.vtranslate('JS_MESSAGE'),
						text: app.vtranslate('JS_SHORTCUT_ALREADY_ADDED'),
						animation: 'show',
						type: 'info'
					};
					Vtiger_Helper_Js.showPnotify(params);
				} else {
					thisInstance.registerPinShortCutEvent(ui.draggable.parent());
					thisInstance.registerSettingShortCutAlignmentEvent();
				}
			}
		});
	},
	registerReAlign: function ()
	{

		var params = {
			'mode': 'realignSettingsShortCutBlock',
			'module': 'Vtiger',
			'parent': 'Settings',
			'view': 'IndexAjax'
		}

		AppConnector.request(params).then(function (data) {
			jQuery('#settingsShortCutsContainer').html(data);

		});
	},
	loadCkEditorElement: function () {
		var customConfig = {};
		var noteContentElement = jQuery('.ckEditorSource');
		var ckEditorInstance = new Vtiger_CkEditor_Js();
		ckEditorInstance.loadCkEditor(noteContentElement, customConfig);
	},
	registerSaveIssues: function () {
		var container = jQuery('.addIssuesModal');
		container.validationEngine(app.validationEngineOptions);
		var title = jQuery('#titleIssues');
		var CKEditorInstance = CKEDITOR.instances['bodyIssues'];
		var thisInstance = this;
		var saveBtn = container.find('.saveIssues');
		saveBtn.click(function () {
			if (container.validationEngine('validate')) {
				var body = CKEditorInstance.document.getBody().getHtml();
				var params = {
					module: 'Github',
					parent: app.getParentModuleName(),
					action: 'SaveIssuesAjax',
					title: title.val(),
					body: body
				};
				AppConnector.request(params).then(function (data) {
					app.hideModalWindow();
					thisInstance.reloadContent();
					if (data.result.success == true) {
						var params = {
							title: app.vtranslate('JS_LBL_PERMISSION'),
							text: app.vtranslate('JS_ADDED_ISSUE_COMPLETE'),
							type: 'success',
							animation: 'show'
						};
						Vtiger_Helper_Js.showMessage(params);
					}
				});
			}
		});
		jQuery('[name="confirmRegulations"]').on('click', function () {
			var currentTarget = jQuery(this);
			if (currentTarget.is(':checked')) {
				saveBtn.removeAttr('disabled');
			} else {
				saveBtn.attr('disabled', 'disabled');
			}
		});
	},
	reloadContent: function () {
		jQuery('.massEditTabs li.active').trigger('click');
	},
	resisterSaveKeys: function (modal) {
		var thisInstance = this;
		var container = modal.find('.authModalContent');
		container.validationEngine(app.validationEngineOptions);
		container.find('.saveKeys').click(function () {
			if (container.validationEngine('validate')) {
				var params = {
					module: 'Github',
					parent: app.getParentModuleName(),
					action: 'SaveKeysAjax',
					username: $('[name="username"]').val(),
					client_id: $('[name="client_id"]').val(),
					token: $('[name="token"]').val()
				};
				container.progressIndicator({});
				AppConnector.request(params).then(function (data) {
					container.progressIndicator({mode: 'hide'});
					if (data.result.success == false) {
						var errorDiv = container.find('.errorMsg');
						errorDiv.removeClass('hide');
						errorDiv.html(app.vtranslate('JS_ERROR_KEY'));
					} else {
						app.hideModalWindow();
						thisInstance.reloadContent();
						var params = {
							title: app.vtranslate('JS_LBL_PERMISSION'),
							text: app.vtranslate('JS_AUTHORIZATION_COMPLETE'),
							type: 'success',
							animation: 'show'
						};
						Vtiger_Helper_Js.showMessage(params);
					}
				},
						function (error, err) {
							container.progressIndicator({mode: 'hide'});
							app.hideModalWindow();
						});
			}

		});
	},
	registerTabEvents: function () {
		var thisInstance = this;
		jQuery('.massEditTabs li').on('click', function () {
			thisInstance.loadContent(jQuery(this).data('mode'));
		});
	},
	registerPagination: function () {
		var page = jQuery('.pagination .pageNumber');
		var thisInstance = this;
		page.click(function () {
			thisInstance.loadContent('Github', $(this).data('id'));
		});
	},
	registerAuthorizedEvent: function () {
		var thisInstance = this;
		jQuery('.showModal').on('click', function () {
			app.showModalWindow(jQuery('.authModal'), function (container) {
				thisInstance.resisterSaveKeys(container);
			});
		});
	},
	registerEventsForGithub: function (container) {
		var thisInstance = this;
		thisInstance.registerAuthorizedEvent();
		thisInstance.registerPagination();
		app.showBtnSwitch(container.find('.switchBtn'));
		container.find('.switchAuthor').on('switchChange.bootstrapSwitch', function (e, state) {
			thisInstance.loadContent('Github', 1);
		});
		container.find('.switchState').on('switchChange.bootstrapSwitch', function (e, state) {
			thisInstance.loadContent('Github', 1);
		});

		$('.addIssuesBtn').on('click', function () {
			var params = {
				module: 'Github',
				parent: app.getParentModuleName(),
				view: 'AddIssue'
			};
			container.progressIndicator({});
			AppConnector.request(params).then(function (data) {
				container.progressIndicator({mode: 'hide'});
				app.showModalWindow(data, function () {
					thisInstance.loadCkEditorElement();
					thisInstance.registerSaveIssues();
				});
			});
		});
	},
	loadContent: function (mode, page) {
		var thisInstance = this;
		var container = jQuery('.indexContainer');
		var state = container.find('.switchState');
		var author = container.find('.switchAuthor');
		var params = {
			mode: mode,
			module: app.getModuleName(),
			parent: app.getParentModuleName(),
			view: 'Index',
			page: page
		};
		if (state.is(':checked')) {
			params.state = 'closed';
		} else {
			params.state = 'open';
		}
		params.author = author.is(':checked');
		var progressIndicatorElement = jQuery.progressIndicator({
			position: 'html',
			'blockInfo': {
				'enabled': true,
				'elementToBlock': container
			}
		});
		AppConnector.request(params).then(function (data) {
			progressIndicatorElement.progressIndicator({mode: 'hide'});
			container.html(data);
			if (mode == 'Index') {
				thisInstance.registerSettingsShortcutClickEvent();
				thisInstance.registerDeleteShortCutEvent();
				thisInstance.registerWidgetsEvents();
				thisInstance.registerAddShortcutDragDropEvent();
				thisInstance.registerSettingShortCutAlignmentEvent();
			} else {
				thisInstance.registerEventsForGithub(container);
			}
		});
	},
	registerEvents: function () {
		this.registerTabEvents();
		this.reloadContent();
	}

});
