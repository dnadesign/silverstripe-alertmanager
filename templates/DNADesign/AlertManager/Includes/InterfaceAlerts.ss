<% if InterfaceAlerts %>
	<div class="alerts">
		<% loop InterfaceAlerts %>
			<div class="alert_item alert_item__$Type">
				<h3>$Content</h3>
			</div>
		<% end_loop %>
	</div>
<% end_if %>