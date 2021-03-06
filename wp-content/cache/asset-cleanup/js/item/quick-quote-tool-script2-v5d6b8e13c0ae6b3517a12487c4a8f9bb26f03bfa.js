/*!/wp-content/plugins/quick-quote-tool/assets/js/common.js*/
$(document).ready(function(){$('*[href="#quote_link"]').on('click',function(){event.preventDefault();$('.quote-cont').show()})
$('.quote-close-btn').click(function(event){event.preventDefault();$('.quote-cont').hide()});$('.product-list .product-list__item').each(function(){$(this).click(function(event){event.preventDefault();$href=$(this).attr('href');$($href).show();currentSection={slug:$($href).attr('data-section'),title:$(this).text().trim(),img:$(this).find('img').attr('src')};console.log(currentSection)
$(this).parent().hide()})});$('.navigation .previous-btn').click(function(event){event.preventDefault();$($href).hide();$('.product-list').show()});$('.product-checked .form-item .form-item__header').each(function(){var counter=0;$(this).click(function(){$(this).toggleClass('active');counter++;if(counter%2!=0){$(this).siblings().fadeIn()}else{$(this).siblings().fadeOut()}})});$('.select').each(function(index,item){$(this).change(function(){if($(this).children('option:selected').val()!=$(this).children('option:first-of-type').val()){$(this).parent().addClass('active')}else{$(this).parent().removeClass('active')}})});$('#svc').change(function(){if($(this).children('option:selected').val()=='Cardboard Stencil Cutting'){$('#svc-size').fadeIn();$('#svc-qty').fadeIn();$('#svc-cutting').fadeOut();$('#svc-length').fadeOut()}else if($(this).children('option:selected').val()=='Vinyl Cutting'){$('#svc-size').fadeOut();$('#svc-qty').fadeOut();$('#svc-cutting').fadeIn();$('#svc-length').fadeIn()}else{$('#svc-size').fadeOut();$('#svc-qty').fadeOut();$('#svc-cutting').fadeOut();$('#svc-length').fadeOut()}});$('.quickQuoteToolPluginSettingsFormSelector button').on('click',function(){event.preventDefault();var target=$(this).attr('data-target');$('.quickQuoteToolPluginSettingsForm').removeClass('active');$('.quickQuoteToolPluginSettingsForm[data-page="'+target+'"]').addClass('active');$('.quickQuoteToolPluginSettingsFormSelector button').removeClass('active');$(this).addClass('active')})
$('button.quote-btn').on('click',function(){event.preventDefault();var sectionBlock=$(this).closest('.product-item');var section=sectionBlock.attr('data-section');var settings=makeRequest({action:'quick_quote_tool_get_settings',section:section});var order={};order.sum=basePrice;order.fields=[];var proceededSlugs=[];var verification=!0;sectionBlock.find('select').each(function(){if($(this).closest('.form-item').css('display')=='none'){return!0}
var name=$(this).attr('name');var value=$(this).val()
if(sectionBlock.find('input[type=checkbox][name='+name+']:checked').length>0){$(this).val('')}
if(value===''&&sectionBlock.find('input[type=checkbox][name='+name+']:checked').length===0){verification=!1;alert('Field '+name+' is required');return!1}})
if(!verification){return!1}
sectionBlock.find('select,input').each(function(){if($(this).closest('.form-item').css('display')=='none'){return!0}
var name=$(this).attr('name');var value=$(this).val()
switch($(this).prop("tagName")){case 'SELECT':if(value!==''&&proceededSlugs.indexOf(name)===-1){order.fields.push(name+': '+value);var setting=settings[name][value];if(setting===undefined||setting===null){setting='+0'}
switch(setting.substr(0,1)){case '+':order.sum+=parseFloat(setting.replace('+',''));break;case '*':order.sum+=parseFloat(setting.replace('*',''));break}}
break;case 'INPUT':if($(this).prop('checked')===!0){if(value!==''&&proceededSlugs.indexOf(name)===-1){order.fields.push(name+': '+value);var setting=settings[name][value];if(setting===undefined||setting===null){setting='+0'}
switch(setting.substr(0,1)){case '+':order.sum+=parseFloat(setting.replace('+',''));break;case '*':order.sum+=parseFloat(setting.replace('*',''));break}}}
break}})
orderData=order;$('.product-checked').hide();$('.result-slide .sectionTitle').text(currentSection.title)
$('.result-slide .orderSumInput').val(order.sum+'$')
$('.result-slide .sectionTitleWrapper style').remove();$('.result-slide .sectionTitleWrapper').html('<style type="text/css">\n'+'                                            .apparel-title:before{\n'+'                                                background: url('+currentSection.img+');\n'+'                                                background-size: cover;\n'+'                                            }\n'+'                                        </style>')
$('.result-slide').show()})
$('select[name="material"]').on('change',function(){event.preventDefault();var block=$(this).closest('.product-item');switch($(this).val()){case "cardboard_stencil_cutting":block.find('select[name="size"]').closest('.form-item').show();block.find('select[name="quantity"]').closest('.form-item').show();block.find('select[name="cutting"]').closest('.form-item').hide();block.find('select[name="length"]').closest('.form-item').hide();break;case "vinyl_cutting":block.find('select[name="size"]').closest('.form-item').hide();block.find('select[name="quantity"]').closest('.form-item').hide();block.find('select[name="cutting"]').closest('.form-item').show();block.find('select[name="length"]').closest('.form-item').show();break}})
$('select[name=total_print_locations]').on('change',function(){event.preventDefault();var count=$(this).val();count=parseInt(count);if(isNaN(count)){count=0}
var block=$(this).closest('.product-item-form').find('select[name="number_of_ink_colors"]').closest('.form-item__input');var iterator=0;block.find('.row').each(function(){if(iterator!=0){$(this).remove()}
iterator++})
for(let i=0;i<count;i++){block.append(block.find('.row').eq(0).clone(!0))}
block.find('.row').eq(0).remove()})
$('.go_back_to_product_checked').on('click',function(){$('.result-slide').hide();$('.product-checked').show()})
$('.goBackToPreFinish').on('click',function(){$('.finished-slide').hide();$('.tell_more-slide').show()})
$('.goToContactDataSlide').on('click',function(){$('.result-slide').hide();$('.contact-data .sectionTitle').text(currentSection.title)
$('.contact-data .sectionTitleWrapper').append('<style type="text/css">\n'+'                                            .apparel-title:before{\n'+'                                                background: url('+currentSection.img+');\n'+'                                                background-size: cover;\n'+'                                            }\n'+'                                        </style>')
$('.contact-data').show()})
$('.finallySubmitOrder').on('click',function(){event.preventDefault();contactData={};contactData.email=$('.contact-data .contact_data_email').val();contactData.company=$('.contact-data .contact_data_company').val();contactData.name=$('.contact-data .contact_data_name').val();contactData.phone=$('.contact-data .contact_data_phone').val();for(var key in contactData){if(['email','name','phone'].indexOf(key)!==-1&&contactData[key]===''){alert('Field '+key+' is required');return!1}}
$('.contact-data').hide();$('.tell_more-slide .gform_page_fields li').hide();$('.tell_more-slide .gform_page_fields li').each(function(){if($(this).attr('data-section')==undefined||$(this).attr('data-section').split(',').indexOf(currentSection.slug)!=-1){$(this).show()}})
$('.tell_more-slide .sectionTitle').text(currentSection.title)
$('.tell_more-slide').show()})
$('.goBackToContacts').on('click',function(){event.preventDefault();$('.tell_more-slide').hide();$('.contact-data').show()})
$('.goToFinishSlide').on('click',function(){event.preventDefault();$('.tell_more-slide').hide();var inputData={};$('.tell_more-slide .gform_page_fields li.quote_data_field').each(function(){if($(this).css('display')!='none'){var text=$(this).find('.gfield_label').text();text=text.trim().replace("\n",'');var value=$(this).find('.ginput_container input');if($(this).find('.ginput_container input[type=checkbox]').length>0||$(this).find('.ginput_container input[type=radio]').length>0){value=$(this).find('.ginput_container input:checked');if(value.length==0){return!0}}
if(value.length>1){var newValue='';for(let i=0;i<value.length;i++){newValue+=value.eq(i).val()+' '}
value=newValue}else{value=value.val()}
if(value==''){return!0}
inputData[text]=value}})
tellMoreData=inputData;$('.finished-slide .sectionTitle').text(currentSection.title)
$('.finished-slide').show()})
$('.finished-slide input[name=input_109]').on('change',function(){if($(this).val()=='Yes'){$('.isShippingField').show()}else{$('.isShippingField').hide()}})
$('.goToConfirmationPage').on('click',function(){event.preventDefault();$('.contact-data').hide();$('.result-slide').show()})
$('.goToFinishingSlide').on('click',function(){event.preventDefault();$('.finished-slide').hide();$('.tell_more-slide').show()})
$('.confirmOrder').on('click',function(){event.preventDefault();shippingData={};shippingData['Will You Require Your Order to be Shipped?']=$('.finished-slide input[name=input_109]:checked').val();if(shippingData['Will You Require Your Order to be Shipped?']=='Yes'){shippingData['Street Address']=$('.finished-slide input[name="input_17.1"]').val();shippingData['Address Line 2']=$('.finished-slide input[name="input_17.2"]').val();shippingData.City=$('.finished-slide input[name="input_17.3"]').val();shippingData['State / Province / Region']=$('.finished-slide input[name="input_17.4"]').val();shippingData['ZIP / Postal Code']=$('.finished-slide input[name="input_17.5"]').val();shippingData.Country=$('.finished-slide select[name="input_17.6"]').val()}
shippingData.Deadline=$('.finished-slide input[name=input_16]').val();shippingData['Special Notes']=$('.finished-slide textarea[name=input_15]').val();shippingFile=$('#gform_browse_button_5_173').prop('files')[0];var result=makeRequest({action:'quick_quote_tool_add_order',order:JSON.stringify({contactData:contactData,orderData:orderData,currentSection:currentSection,tellMoreData:tellMoreData,shippingData:shippingData,}),shippingFile:shippingFile,});console.log(result)
alert('Thanks for Order')
window.location.reload()})
function makeRequest(data){data.nonce=specialObj.security;var form_data=new FormData();for(var key in data){form_data.append(key,data[key])}
var returnData={};$.ajax({type:'POST',url:specialObj.ajaxurl,data:form_data,async:!1,cache:!1,contentType:!1,processData:!1,success:function(data){data=jQuery(data).find('supplemental data').text();data=JSON.parse(data);returnData=data}});return returnData}
var basePrice=30+Math.floor(Math.random()*100);var currentSection={};var orderData={};var contactData;var tellMoreData;var shippingData;var shippingFile})
;