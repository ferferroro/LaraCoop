function borrower_id_selected_on_add_loan() {
    $.ajax({
       type:'GET',
       url: "/borrower/get_borrower/",
       data:{
        id: $("#borrower_id").val()
      },
       success:function(data) {
          document.getElementById("percent_penalty").value = data.percent_penalty;
          document.getElementById("percent_interest").value = data.percent_interest;
       }
    });
 }

 
 function member_id_selected_on_add_contribution() {
   $.ajax({
      type:'GET',
      url: "/member/get_member/",
      data:{
       id: $("#member_id").val()
     },
      success:function(data) {
         document.getElementById("amount").value = data.monthly_contribution;
      }
   });
}

$('#payLoanDetailModal').on('show.bs.modal', function (event) {

   var loan_detail_id = $(event.relatedTarget).attr("data-loan-detail-id");
   var loan_detail_type_line = $(event.relatedTarget).attr("data-loan-detail-type-line");
   var loan_detail_date_payment_due = $(event.relatedTarget).attr("data-loan-detail-date-payment-due");
   var loan_detail_term = $(event.relatedTarget).attr("data-loan-detail-term");
   var loan_detail_amount_due = $(event.relatedTarget).attr("data-loan-detail-amount-due");
   var loan_detail_amount_payed = $(event.relatedTarget).attr("data-loan-detail-amount-payed");
   var data_loan_detail_pay_form_action = $(event.relatedTarget).attr("data-loan-detail-pay-form-action");
   
   $('#loan_detail_type_line').html(loan_detail_type_line)
   $('#loan_detail_date_payment_due').html(loan_detail_date_payment_due)
   $('#loan_detail_term').html(loan_detail_term)
   $('#loan_detail_amount_due').html(loan_detail_amount_due)
   $('#loan_detail_amount_payed').html(loan_detail_amount_payed)
   $('#loan_detail_amount_payed').html(loan_detail_amount_payed)
   $('#loan_detail_pay_form').attr('action', data_loan_detail_pay_form_action);
});

function update_side_bg_color_on_change_of_bg_color() {
   alert(
      $(this).html()
      );
   $.ajax({
      type:'PUT',
      url: "/system_user/update_side_bg_color/",
      data:{
      "_token": $('#fixed_plugin_token').val(),
      "color": "asdf",
      // "color": $(this).data('color'),
      // "color2": $(this).val()
     },
      success:function(data) {
         // document.getElementById("amount").value = data.monthly_contribution;
         console.log(data);
      }
   });
}

$('#change_bg_to_white').on('click',function(){  
   call_update_side_bg_color($(this).data('color'));
});

$('#change_bg_to_black').on('click',function(){  
   call_update_side_bg_color($(this).data('color'));
});

function call_update_side_bg_color(color) 
{ 
   $.ajax({
      type:'PUT',
      url: "/system_user/update_side_bg_color/",
      data:{
      "_token": $('#fixed_plugin_token').val(),
      "side_bg_color": color
     },
      success:function(data) {
         console.log(data);
      }
   });
}

$('#change_txt_to_primary').on('click',function(){  
   call_side_active_color($(this).data('color'));
});

$('#change_txt_to_info').on('click',function(){  
   call_side_active_color($(this).data('color'));
});

$('#change_txt_to_success').on('click',function(){  
   call_side_active_color($(this).data('color'));
});

$('#change_txt_to_warning').on('click',function(){  
   call_side_active_color($(this).data('color'));
});

$('#change_txt_to_danger').on('click',function(){  
   call_side_active_color($(this).data('color'));
});


function call_side_active_color(color) 
{ 
   $.ajax({
      type:'PUT',
      url: "/system_user/update_side_active_color/",
      data:{
      "_token": $('#fixed_plugin_token').val(),
      "side_active_color": color
     },
      success:function(data) {
         console.log(data);
      }
   });
}