<div class="crm-block crm-form-block">
  {if $smarty.get.state eq 'done'}
    <div class="help">
      {ts}Copied Successfully.{/ts}<br/>
    </div>
  {else}
    <p>{ts}Running this will copy spouse address.{/ts}</p>
    <div class="crm-submit-buttons">
      {include file="CRM/common/formButtons.tpl"}
    </div>
  {/if}
</div>
