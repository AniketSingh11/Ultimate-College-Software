$(function(){
  var currencies = [
    { value: 'LKG001', name: 'AFN', reg: 'reg01', cid: '1', sid: '1' },
    { value: 'LKG002', name: 'ALL', reg: 'reg02', cid: '1', sid: '1' },
    { value: 'UKG001', name: 'DZD', reg: 'reg03', cid: '1', sid: '1' },
    { value: 'UKG002', name: 'EUR', reg: 'reg04', cid: '1', sid: '1' },
    { value: 'FS001', name: 'AOA', reg: 'reg05', cid: '1', sid: '1' },
    { value: 'FS002r', name: 'XCD', reg: 'reg06', cid: '1', sid: '1' },    
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies,
    onSelect: function (suggestion) {
      //var thehtml = '<input type="text" name="aname" id="aname" size="32" value="'+ suggestion.value +'" readonly/> <br> <strong>Symbol:</strong> ' + suggestion.name + '<strong>Book:</strong>' + suggestion.book;
	  
	  var thehtml = '<li><strong class="name">'+ suggestion.name +'</strong></li><li>Roll No: '+ suggestion.value +'</li><li>Reg No: '+ suggestion.reg +'</li><li>Class: '+ suggestion.cid +'</li><li>Section/Group: '+ suggestion.sid +'</li>';
	  
      $('.client_details').html(thehtml);
    }
  });
  

});