function xborrower_id_selected_on_add_loan() {
    
    // set text box value here
    var txt =  document.getElementById('borrower_id');
    // txt.value = "assign_here";
    var a = $("#borrower_id").val();
    console.log(a);

    
  }

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


  

// $(document).ready(function(){

//    $('#payLoanDetailModal').on('show', function(e) {
//       console.log('123');
//       var link     = e.relatedTarget(),
//           modal    = $(this),
//           loan_detail_id = link.data("loan_detail_id"),
//           loan_detail_type_line    = link.data("loan_detail_type_line");
   
//       // modal.find("#loan_detail_id").val(loan_detail_id);
//       modal.find("#loan_detail_type_line").html(loan_detail_id);
//       // $('#loan_detail_type_line').html(loan_detail_id);
//    });

//  });










//  $('#payLoanDetailModal').on('shown.bs.modal', function (e) {
//    // var link = e.relatedTarget(),
//    //        modal    = $(this),
//    //        loan_detail_id = link.data("loan_detail_id"),
//    //        loan_detail_type_line    = link.data("loan_detail_type_line");


//       var ab = $(this).data('loanDetailId');

//       console.log(ab);
   
//       // // modal.find("#loan_detail_id").val(loan_detail_id);
//       // modal.find("loan_detail_type_line").html($(this).data('id'));
//       // // $('#loan_detail_type_line').html(loan_detail_id);
      
//  })



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