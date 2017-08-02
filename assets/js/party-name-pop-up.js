function openPopUp(){

    return vex.dialog.open({
      message: 'Enter Account Name:', showCloseButton: true,
         className: 'vex-theme-os',
      input: [
          '<div class="form-group">',
            '<input name="account_name" type="text" placeholder="Enter Account Name" required />',
          '</div>',
          '<div class="form-group">',
            '<select name="account_group" placeholder="Enter Account Name" required class="form-control">',
            '<option disabled>-Select Account Group-</option>',
            '<option value="SundryCreditors">Sundri Creditors</option>',
            '<option value="SundryDebtors">Sundry Debtors</option>',
            '</select>',
          '</div>',
      ].join(''),
      buttons: [
          jQuery.extend({}, vex.dialog.buttons.YES, { text: 'Add' }),
          jQuery.extend({}, vex.dialog.buttons.NO, { text: 'Back' })
      ],
      callback: function (data) {
          if (!data) {
              console.log('Cancelled')
          } else {

              $.ajax({
                method: "POST",
                url: getBaseUrl()+'/api/accounts/add',
                data: { name: data.account_name, accounts_group:data.account_group}
              })
                .done(function( msg ) {
                   console.log(msg)
                  if(msg.STATUS == "SUCCESS"){

                    window.GATE_ENTRY.accounts.push(msg.RESPONSE);
                    window.GATE_ENTRY.accountId = msg.RESPONSE.id;
                    window.GATE_ENTRY.$forceUpdate();
                    
                 }

              });
          }
      } //callback
  });   

}
