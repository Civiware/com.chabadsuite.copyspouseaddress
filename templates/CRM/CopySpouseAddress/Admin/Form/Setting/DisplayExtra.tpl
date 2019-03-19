<table class="share_spouse_address_loc_type-table" style="display:none !important">
  <tr class="crm-preferences-display-form-share_spouse_address_loc_type">
    <td class="label">{$form.share_spouse_address_loc_type.label}</td>
    <td>{$form.share_spouse_address_loc_type.html}</td>
  </tr>
  <tr class="crm-preferences-display-form-share_spouse_address_cron_run">
    <td class="label">{$form.share_spouse_address_cron_run.label}</td>
    <td>{$form.share_spouse_address_cron_run.html}</td>
  </tr>
</table>
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $($('table.share_spouse_address_loc_type-table tr')).insertAfter('.crm-miscellaneous-form-block .crm-miscellaneous-form-block-allow_alert_autodismissal');
  });
</script>
{/literal}
