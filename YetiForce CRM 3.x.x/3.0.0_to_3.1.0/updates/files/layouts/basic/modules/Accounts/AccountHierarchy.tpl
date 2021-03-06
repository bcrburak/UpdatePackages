{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Contributor(s): YetiForce.com
********************************************************************************/
-->*}
{strip}
	<div id="accountHierarchyContainer" class="modelContainer modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" title="{vtranslate('LBL_CLOSE')}">x</button>
					<h3 class="modal-title">{vtranslate('LBL_SHOW_ACCOUNT_HIERARCHY', $MODULE)}</h3>
				</div>
				<div class="modal-body">
					<div id ="hierarchyScroll" style="margin-right: 8px;">
						<table class="table table-bordered">
							<thead>
								<tr class="blockHeader">
									{foreach item=HEADERNAME from=$ACCOUNT_HIERARCHY['header']}
										<th>{vtranslate($HEADERNAME, $MODULE)}</th>
									{/foreach}
								</tr>
							</thead>
							<tbody>
								{foreach key=RECORD_ID item=ENTRIES from=$ACCOUNT_HIERARCHY['entries'] name=hierarchyEntries}
									<tr {if $smarty.foreach.hierarchyEntries.first} class="parentAccount" {/if}>
										{foreach item=LISTFIELDS from=$ENTRIES}
											<td>
												{if $LISTFIELDS['fieldname'] == 'active' && Users_Privileges_Model::isPermitted($MODULE, 'EditView', $RECORD_ID)}
													<button class="btn{if $LISTFIELDS['rawData']} btn-success {else} btn-warning  {/if}btn-xs toChangeBtn" data-record-id="{$RECORD_ID}" data-fieldname="{$LISTFIELDS['fieldname']}">
														{$LISTFIELDS['data']}
													</button>
												{else}
													{$LISTFIELDS['data']}
												{/if}
											</td>
										{/foreach}
									</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<div class=" pull-right cancelLinkContainer">
						<button class="btn btn-warning" type="reset" data-dismiss="modal"><strong>{vtranslate('LBL_CLOSE', $MODULE)}</strong></button>
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
