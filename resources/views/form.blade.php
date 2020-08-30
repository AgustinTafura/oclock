@extends('layouts.app')

@section('styles')
  <link href="{{ asset('css/jquery.steps.css')}}" rel="stylesheet">
@endsection

@section('scripts')
  <script src="{{ asset('js/jquery.steps.js')}}" defer></script> <!-- Script: JQUERY.STEPS -->
  <script src="{{ asset('js/jquery.steps.min.js')}}" defer></script> <!-- Script: JQUERY.STEPS -->
  <script >

    $(function(){
      getCategory()
      address_id = 0

      // $('#datalist').prop('display', 'none');

      $('.add_shift').click(function(){
          $("select[name^='days").change(function(i,o){
            return $("select[name^='days")
          })
      })



      // ------------------------------------------------------- Form-register Provider ------------------------------------------------------------------------//
      $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: "#title#",
        onFinishing: function (event, currentIndex){
          return true
        },
        onFinished: function (event, currentIndex) {
          $.when(
            validateBookings(),
            validateProvider(),
            validateAddress(),
            validateCompany(),
            $.each($('datalist option'), function(i,opt){
              if($('#establishment_name')[0].value === opt.value){
                  address_id = opt.attributes['address_id'].value
                  var company_id = opt.attributes['company_id'].value
                  return address_id
              }
            }),
          ).then(
            function() {
              console.log("1 addres_id" + address_id);
              if (address_id) {
                console.log("2 addres_id" + address_id);
                return storeProvider(address_id)
              } else {
                $.when(
                storeAddress().then(
                function(result){
                    return storeCompany(result)
                }).then(
                  function(result){
                    console.log(newCompanyId);
                    console.log("3 addres_id" + address_id);
                    console.log(result);
                    return storeProvider(result)
                  }
                ))
              }
            console.log("4 addres_id" + address_id);
            }
          ).then(
            function(result){
              console.log('submit');
              // setTimeout($('form').submit(), 5000);
              // return $('form').submit();
            }
          )
        },
        onStepChanging: function (event, currentIndex, newIndex, title) {
          //next
          event.preventDefault();
          if(currentIndex == 0 && newIndex == 1 ){
            next = true
            // checkCurrenSectiontRequired()
            return next
          }

          if(currentIndex == 1 && newIndex == 2 ){
            next = true
            // checkCurrenSectiontRequired()
          $('#category_id').focus()
            return next
          }

          if(currentIndex == 2 && newIndex == 3 ){
            next = true
            // checkCurrenSectiontRequired()
            return next
          }

          if(currentIndex == 3 && newIndex == 4 ){
            next = true
            // checkCurrenSectiontRequired()
            return next
          }

          return true;
        },
      });


      // Section - Horario apertura y cierre ------------------------------------------------------------------------
      $.each($('.weekDay'), function(i,child){
        $(this.children[1].firstChild).on('change', function(){
          pivote = this.parentElement;
          bttn = $(child.firstChild);
          bttn.addClass('disabled');
          $($(bttn)[0].firstChild).val('0');

          if(this.value == 'closed') {
            $.each($(pivote.children), function(i,child){
              if(i != 0){
                child.remove()
              }
                $(this).removeClass('col-5');
                $(this).addClass('col-12');
            })
          }

          if(this.value != 'closed') {
            bttn.removeClass('disabled');
            $.each($(pivote.children), function(i,child){
              if(i != 0){
                child.remove()
              }
                $(this).removeClass('col-5');
                $(this).addClass('col-12');
            })
            $($(bttn)[0].firstChild).val('1');

            if(this.value != '24hours') {
              $(this).removeClass('col-12');
              $(this).addClass('col-5');

              if(pivote.childElementCount == 1){

              $(this).after('<select  class=" form-control show-tick col-5 close_hour " required autocomplete=""> <option class="nullOption" value="" selected disabled>__ : __</option> <optgroup label="Horario cierre"> </optgroup></select>');
              // $(pivote.children[1]).append('<option value="" selected disabled> _ _ : _ _  </option>');
              for (var i = 0; i < 24; i++) {
                if(i <10 ) {
                 $option = "<option value='0" + i + ":00:00'>0" + i + ":00</option> <option value='0" + i + ":30:00'>0" + i + ":30</option>";
               } else {
                 $option = "<option value='" + i + ":00:00'>" + i + ":00</option> <option value='" + i + ":30:00'> " + i + ":30</option>";
               }

               $(pivote.children[1]).append($option);

              }
              // $id = child.classList[1] + 'close_hour';
              $id = 'days' + child.classList[1] + 'close_hour0';
              $name = 'days[' + child.classList[1] + '][close_hour][]';
              $(pivote.children[1]).attr('name', $name);
              $(pivote.children[1]).attr('id', $id);
              $(pivote).append('<label class="col-1 add_shift">+</label>');
              }
            }

            // BUTTON + ADD SHIFT
            addBttn = $('.add_shift');
            addBttn.on('click', function(e) {
              e.preventDefault();

              ident = $(this.parentElement)[0]
              bttnOpen = $(this.parentElement)[0].children[0]
              bttnClose = $(this.parentElement)[0].children[1]

              dayO = bttnOpen.name;
              dayC = bttnClose.name;
              row = $(this.parentElement)[0].childElementCount;
              row = (row/3);
              dayORow = bttnOpen.id.replace("open_hour0", "open_hour"+row);
              dayCRow = bttnClose.id.replace("close_hour0", "close_hour"+row);

              bttOpenNew = $(bttnOpen).clone()
              bttCloseNew = $(bttnClose).clone()

              if(bttOpenNew.hasClass('is-invalid')){
                bttOpenNew.removeClass('is-invalid')
              }

              if(bttCloseNew.hasClass('is-invalid')){
                bttCloseNew.removeClass('is-invalid')
              }


              var nullOption = '<option hidden class="nullOption" value="" selected disabled>__ : __</option>'
              bttOpenNew.append(nullOption)

              bttOpenNew[0].firstChild.remove();
              bttOpenNew[0].firstChild.remove();
              bttOpenNew[0].firstChild.remove();

              bttOpenNew.attr('name', dayO)
              bttCloseNew.attr('name', dayC)

              bttOpenNew.attr('id', dayORow)
              bttCloseNew.attr('id', dayCRow)

              bttOpenNew.addClass(ident.id+row)
              bttCloseNew.addClass(ident.id+row)


              bttOpenNew.appendTo(this.parentElement)
              bttCloseNew.appendTo(this.parentElement)
              $(this.parentElement).append('<label class="col-1 remove_shift '+ident.id+row+'">-</label>')

              // BUTTON + ADD SHIFT
              removeBttn = $('.remove_shift');
              removeBttn.on('click', function() {
                classElementsToRemove = this.classList[2];
                $.each($('.'+classElementsToRemove), function(i,element){
                  this.remove();
                })
              })
            })
          }
        })
      })
      //quitar Class  al ultimo Section
      $(".well.well-sm.text-center.my-5").removeClass('my-5');

      // -------------------------------------------------------  Events  ------------------------------------------------------------------------//

      // $("#establishment_id").on('change',
      //   function(){
      //     $('#establishment_name').attr('hidden', 'true')
      //     $('#establishment_name').removeAttr('required')
      //     if(this.value >=1 ) {
      //       $('#establishment_name').removeAttr('hidden')
      //       $('#establishment_name').attr('required', 'true')
      //     }
      //   }
      // );

      $('#establishment_name').on('change', function(element){
        console.log(element);
        var attr = $('#company_contact_phone').attr('disabled');
        console.log(attr);
        if (typeof attr !== typeof undefined && attr !== false){
          $('#company_contact_phone').removeAttr('disabled')
              $('#street_name').removeAttr('disabled')
              $('#street_number').removeAttr('disabled')
              $('#company_email').removeAttr('disabled')
              $('#floor').removeAttr('disabled')
              $('#apartment').removeAttr('disabled')
              $('#zip').removeAttr('disabled')
              $('#state').removeAttr('disabled')
              $('#city').removeAttr('disabled')

              $('#street_name').val('')
              $('#street_number').val('')
              $('#floor').val('')
              $('#apartment').val('')
              $('#zip').val('')
              $('#state').val('')
              $('#city').val('')
              $('#company_email').val('')
              $('#company_contact_phone').val('')
        } else {
          $.each($('datalist option'), function(i,opt){
            if(this.value === opt.value){
                address_id = this.attributes['address_id'].value
                company_id = this.attributes['company_id'].value
                getCompanyById(company_id)
                getAddressById(address_id)
            }
          })
        }
        console.log(this.value);
                console.log(attr);
      })

      $('section.companyForm select, section.companyForm input').change(
        function(){
          updateCompany = 1

        }
      )

      $('section.addressForm select, section.addressForm input').change(
        function(){
          updateAddress = 1
        }
      )


      $("#category_id").change(
        function(){
          // $('#license_number').attr('hidden', 'true')
          var cat_id = $("#category_id")[0].value;
          $('#license_number').attr('hidden', 'true')

          if(this.value != 0){
            $("#specialty_id").removeAttr("disabled")
            $("#establishment_id").removeAttr("disabled")
            showSpecialties(cat_id)
            showEstablishments(cat_id)
            if(this.value <= 2){
              $('#license_number').removeAttr('hidden')
              $('#license_number').attr('required', 'true')
            }
          } else{
            $("#specialty_id")[0].value = "0"
            $("#specialty_id").attr("disabled", "disabled")
            $("#specialty_id").html("<option value='0' > Especialidad </option>")
            $("#establishment_id").attr("disabled", "disabled")
            $.each($('#establishment_id').children(),function(i, child){
              if(child.value != 0){
                child.remove()
              }
            })
            // $('#establishment_name').attr('hidden', 'true')
            // $('#establishment_name')[0].value = ""
          }
        }
      )


      $('#establishment_name').on('keyup', function(e){
        console.log(e.keyCode);
        if (!e.keyCode ) {
          if(key){
            removeChilds($('datalist'))

            key = 0
          } else {
            var key = 1;
            return key
          }
        }
        if (e.keyCode) {
          removeChilds($('datalist'))
        }
        if (this.value.length >2 && ($('#establishment_id')[0].value == 4 || $('#establishment_id')[0].value == 2) ) {
          datalistSearcher(this)
        } else {
          removeChilds($('datalist'));
        }
      })



      // -------------------------------------------------------  END - Events  ------------------------------------------------------------------------//




    })
        // ------------------------------------------------------- END Form-register Provider ------------------------------------------------------------------------//


        // -------------------------------------------------------  Functions  ------------------------------------------------------------------------//

        function getCompanyById(id){
          return $.ajax({
              // async: 'false',
              url : "/company/get/"+id,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              type : 'GET',
              success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
                console.log(response);
                $('#company_contact_phone').val(response.contact_phone)
                $('#company_contact_phone').attr('disabled', 'disabled')
                $('#company_email').val(response.email)
                $('#company_email').attr('disabled', 'disabled')
              },
              error : function(response, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
              },
            })
        }

        function getAddressById(id){
          // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          return $.ajax({
              // async: 'false',
              url : "/address/get/"+id,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              type : 'GET',
              success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
                console.log(response);
                $('#street_name').val(response.street)
                $('#street_name').attr('disabled', 'disabled')
                $('#street_number').val(response.number)
                $('#street_number').attr('disabled', 'disabled')
                $('#floor').val(response.floor)
                $('#floor').attr('disabled', 'disabled')
                $('#apartment').val(response.apartment)
                $('#apartment').attr('disabled', 'disabled')
                $('#zip').val(response.postal_code)
                $('#zip').attr('disabled', 'disabled')
                $('#state').val(response.state)
                $('#state').attr('disabled', 'disabled')
                $('#city').val(response.city)
                $('#city').attr('disabled', 'disabled')
              },
              error : function(response, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
              },
            })
        }

        function removeChilds(element){
          $.each($(element).children(),function(i, child){
              child.remove()
          });
        }

        function datalistSearcher(element){
          console.log(element.value);
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          min = 1
          max = 1000
          if($('#specialty_id').children()[1]){
            min = $('#specialty_id').children()[1].value
            max = $('#specialty_id').children().last()[0].value
          }

          $.ajax({
            url : "/datalist",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type : 'POST',
            data : {   // la información a enviar
              _token: CSRF_TOKEN,
              "name" : element.value,
              "category_id" : $('#category_id')[0].value,
              "specialty_id" :  $('#specialty_id')[0].value,
              // "category_id_min": min,
              // "category_id_max": max,
            },
            success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;

              $.each(response['companies'], function(index,company){
                $($('datalist')[0].children).each(function(i,dataLisOption){
                  if($(dataLisOption)[0].attributes.name.value == company.id){
                    dataLisOption.remove()
                  }
                })
                $('datalist').append(
                  "<option company_id='" + company.id + "' name=company_id' address_id='" + company.addressId + "'  class='companies' value='" + company.name + "'>"+ company.street +" "+ company.number + "</option>"
                )
              })

            },
            error : function(xhr, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
            },
            complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
            }
          });
        }

        function storeAddress(){
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

          return $.ajax({
              // async: 'false',
              url : "/address",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data : {   // la información a enviar
                _token: CSRF_TOKEN,
                "street_name" : $('#street_name')[0].value,
                "street_number" : $('#street_number')[0].value,
                "floor" : $('#floor')[0].value,
                "apartment" : $('#apartment')[0].value,
                "zip" : $('#zip')[0].value,
                "city" : $('#city')[0].value,
                "state" : $('#state')[0].value,
                "country" : $('#country')[0].value,
              },
              type : 'POST',
              success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
                newAddressId = response
                return newAddressId
              },
              error : function(response, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
              // alert('error al crear la ADDRESS')
              },
            })
          }

        function storeCompany(result){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            return $.ajax({
              url : "/company",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data : {   // la información a enviar
                  _token: CSRF_TOKEN,
                "establishment_name" : $('#establishment_name')[0].value,
                "address_id" : result,
                // "cuit" : $('#cuit')[0].value,
                "company_contact_phone" : $('#company_contact_phone')[0].value,
                "company_email" : $('#company_email')[0].value,
                "category_id" : $('#category_id')[0].value,
                'establishment_id' : $('#establishment_id')[0].value,
              },
              type : 'POST',
              success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
                newCompanyId = response
                return newCompanyId
              },
              error : function(response, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
              // alert('error al crear la COMPANY')
              },
              complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
              }
            })
          }


        function storeProvider(result){
          if (typeof newCompanyId !== typeof undefined && newCompanyId !== false){
            company_id = newCompanyId
          }
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          return $.ajax({
            // async: 'false',
            url : "/provider",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data : {   // la información a enviar
              _token: CSRF_TOKEN,
              "cuit" : $('#cuit')[0].value,
              "license_number" : $('#license_number')[0].value,
              "address_id" : result,
              "specialty_id" :  $('#specialty_id')[0].value,
              'company_id': company_id,
            },
            type : 'POST',
            // dataType : 'json',            // el tipo de información que se espera de respuesta
            success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
              newProviderId = response
              return newProviderId
            },
            error : function(response, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
              // alert('error al crear el PROVIDER')
            },
            complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
            }
          });
        }

        // function storeBookings(){
        //   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //   $.ajax({
        //     url : "/booking",
        //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //     data : {   // la información a enviar
        //       _token: CSRF_TOKEN,
        //       // "days" : ,
        //       "appointmentDuration" :  $('#appointmentDuration')[0].value,
        //       "dateStart" : $('#dateStart')[0].value,
        //     },
        //     type : 'POST',
        //     // dataType : 'json',            // el tipo de información que se espera de respuesta
        //     success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
        //       newProviderId = response
        //       return newProviderId
        //     },
        //     error : function(xhr, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
        //         alert('Disculpe, existió un problema con Provider. Intente más tarde');
        //     },
        //     complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
        //     }
        //   });
        // }

        function showSpecialties(value_category_id) {
          var xhttp;
          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("specialty_id").innerHTML = this.responseText;
            }
          };
          xhttp.open("GET", "/getspecialties/"+value_category_id, true);
          xhttp.send();
        }

        $("#specialty_id").change(
          function(){
            element_id = $("#specialty_id")[0].value;
              showOptions(element_id)
          }
        )

        function showEstablishments(cat_id) {
          $.ajax({
            url : "/getEstablishments/"+cat_id,
            type : 'GET',
            success : function(establishments) {
              if (establishments.length != '0') {
                $.each($('#establishment_id').children(),function(i, child){
                  if(child.value != 0){
                    child.remove()
                  }
                })
                $.each(establishments, function(i, service){
                  $('#establishment_id').append(
                    "<option value="  + service.id + ">"   + service.name +  "</option>"
                  )
                })
              }
            },
            error : function(xhr, status) {
                alert('Disculpe, existió un problema. Intente más tarde');
            },
          });
        }

        function showOptions(element_id) {
          $.ajax({
            url : "/getservices/"+element_id,
            type : 'GET',
            success : function(services) {
              $('#checkbox_service').empty();
              if (services.length == '0') {
              } else {
                $.each(services, function(i, service){
                  $('#checkbox_service').append(
                    "<div class='funkyradio-warning'> <input type='checkbox' name='service_id_[]' id='service_id_"  + service.id + "' value='"  + service.id + "' /> <label for='service_id_"  + service.id + "'> "  + service.name + " </label> </div>"
                  )
                })
              }
            },
            error : function(xhr, status) {
                alert('Disculpe, existió un problema. Intente más tarde');
            },
          });

        }

        function getCategory(){
          $.ajax({
            url : "/category",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type : 'GET',
            success : function(categories) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
              $.each(categories, function(index,category){
                $('#category_id').append(
                  "<option value="  + category.id + ">"   + category.name +  "</option>"
                )
              })
            },
            error : function(xhr, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
              // alert('Disculpe, existió un problema con el Address. Intente más tarde');
            },
            complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
              // alert('Petición realizada');
            }
          });
        }

        function checkCurrenSectiontRequired(){
          $.each($("section.current .required"), function(i, child){
            if(this.value == 0) {
              $(function() {
                $(child).focus()
              })
              next = false
            }
          })
        }

        function correctInputErrors(){
          $.each($('.is-invalid'),function(index,el){
            $(el).change(
              function(){
                $(this).removeClass('is-invalid')
                $(this).popover('hide')
                $(this).popover('disable')

                stepWarningColor = ($(this).parents('section').get(0).id).replace('-p-','-t-')
                $("#" + stepWarningColor).css("background-color", "");
              }
            )
            $(el).focusout(function(){
              $(this).popover('hide')
            })

          })
        }

        function showErrorsvalidation(response){
          // console.log(response);
          $.each(response.responseJSON.errors, function(error,msg){
            var element = $(document).find('[name="'+error+'"]');
            if(!element.length){
              var element =  $(document).find("#"+error);
            }
            var step = $(element).parents('section').get(0).id;
            stepId = step.replace('-p-','-t-')

            $("#" + stepId).get(0).click()
            $("#" + stepId).get(0).style.backgroundColor = 'palevioletred'
            $(element).focus()
            $(element).addClass('is-invalid')
            $(element).attr('data-content', msg)
            correctInputErrors()

            if(element.hasClass('open_hour') || element.hasClass('close_hour')){
              element.css('padding-right','0');
            }

          })
          $('.is-invalid').popover({container: 'body'})
          $('.is-invalid').popover('enable')
        }

        function validateAddress(){
          return $.get('/address/validation', {
            street_name: $('#street_name').get(0).value,
            street_number: $('#street_number').get(0).value,
            floor: $('#floor').get(0).value,
            apartment: $('#apartment').get(0).value,
            zip: $('#zip').get(0).value,
            city: $('#city').get(0).value,
            state: $('#state').get(0).value,
            country: "Argentina",
          }, function(data, estado, xhr){
          }).fail(function(data) {
            showErrorsvalidation(data)
          })
        }

        function validateCompany(){
          return $.get('/company/validation', {
            establishment_name: $('#establishment_name').get(0).value,
            cuit: $('#cuit').get(0).value,
            // address_id: $('#address_id'),
            company_contact_phone: $('#company_contact_phone').get(0).value,
            company_email: $('#company_email').get(0).value,
            category: $('#category_id').get(0).value,
            establishment_id: $('#establishment_id').get(0).value,
          }, function(data, estado, xhr){
          }).fail(function(data) {
            showErrorsvalidation(data)
          })
        }

        function validateProvider(){
          return $.get('/provider/validation', {
            cuit : $('#cuit').get(0).value,
            license_number : $('#license_number').get(0).value,
            // 'user_id',
            // 'company_id',
            specialty_id: $('#specialty_id').get(0).value,
          }, function(data, estado, xhr){
          }).fail(function(data) {
            console.log(data);
            showErrorsvalidation(data)
          })
        }

        function validateBookings(){
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          days = new Array()
          for (var i = 0; i < 7; i++) {
            days.push({'open_hour':[],'close_hour':[]})
          }
          $("select[name^='days").each(function(){
            index = this.name.charAt(5)
            if($(this).hasClass('open_hour')){
              if(this.value == 'closed' || this.value == '24hours' ){
                days[index]["open_hour"] = this.value
              } else{
                days[index]["open_hour"].push(this.value)
              }
            } else if($(this).hasClass('close_hour')) {
              days[index]["close_hour"].push(this.value)
            }
          })
          return $.post('/booking/validation', {
            _token: CSRF_TOKEN,
            data : days,
            appointment_duration: $('#appointment_duration').get(0).value,
            date_start: $('#date_start').get(0).value,
          }, function(data, estado, xhr){
            // console.log('okkkkk');
          }).fail(function(data) {
            // console.log(data);
            showErrorsvalidation(data)
          })
        }


        // function validateBookings(){
        //   var str = $( "form" ).serializeArray();
        //   var postData = new FormData();
        //   $.each(str, function(i, val) {
        //       postData.append(val.name, val.value);
        //   })
        //   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //   return $.ajax({
        //     url: '/booking/validation',
        //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //     data : {
        //       _token: $('meta[name="csrf-token"]').attr('content'),
        //       data : postData,
        //     },
        //     contentType: false,
        //     type: 'POST',
        //     processData: false,
        //     success : function(data, estado, xhr) {
        //       console.log('okkkkk');
        //     },
        //     error : function(data, estado, xhr) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
        //       console.log(data);
        //       console.log('falloo');
        //       showErrorsvalidation(data)
        //     },
        //   })
        // }
  </script>
@endsection


@section('content')
  {{-- <form class="" action="{{ ('/booking/validation')}}" method="GET"> --}}
  <form class="" action="{{ ('/booking')}}" method="POST">

    @csrf
      <div id="wizard">

          <h2>Establecimiento</h2>
          <section class="companyForm">
            <select name="category_id" id="category_id" class=" form-control form-group show-tick col-md-4 required " name="category_id" value="{{old('category_id')}}"  autocomplete="category_id" >
            <option value="0" class="titleCat"> Categoría </option>
            </select>
            <select  disabled name="establishment_id" id="establishment_id" class=" form-control form-group show-tick col-md-4 required " name="establishment_id" value="{{old('establishment_id')}}" required autocomplete="establishment_id" >
              <option value="0"> Tipo de Establecimiento </option>
            </select>
            <input type='text' list="datalist" class='form-control form-group  show-tick col-md-4 required' value='{{old('establishment_name')}}'  autocomplete='establishment_name'  id='establishment_name' name='establishment_name' placeholder='Nombre del Establecimiento'>
            <datalist name='datalist' id="datalist"></datalist>
            <input type="text" class="form-control form-group  show-tick col-md-4 required " id="company_contact_phone" name="company_contact_phone" placeholder="Numero de teléfono" value="{{old('company_contact_phone')}}" required >
            <input type="email" class="form-control form-group  show-tick col-md-4 required " id="company_email" name="company_email" placeholder="Email del Establecimiento" value="{{old('company_email')}}" required>
          </section>

          <h2>Direccion</h2>
          <section class="addressForm">
            <input type="text" class="form-control form-group col-12 col-md-8 required" value="{{old('street_name')}}" required autocomplete="street_name" id="street_name" name="street_name" placeholder="Calle" data-placement="top" data-toggle="popover">
            <input type="text" class="form-control form-group col-6 col-md-4 required" value="{{old('street_number')}}"  autocomplete="street_number"  id="street_number" name="street_number" placeholder="Numero" data-placement="top" data-toggle="popover">
            <input type="text" class="form-control form-group col-6 col-md-4" value="{{old('floor')}}" id="floor" name="floor" placeholder="Piso" data-placement="top" data-toggle="popover"  data-content=" It's very engaging. Right?">
            <input type="text" class="form-control form-group col-6 col-md-4" value="{{old('apartment')}}" id="apartment" name="apartment" placeholder="Depto" data-placement="top" data-toggle="popover">
            <input type="text" class="form-control form-group col-6 col-md-4 required"value="{{old('zip')}}" required autocomplete="zip"  id="zip" name="zip" placeholder="Codigo Postal" data-placement="top" data-toggle="popover">
            <input type="text" class="form-control form-group col-md-4 required" value="{{old('state')}}" required autocomplete="state"  id="state" name="state" placeholder="Provincia" data-placement="top" data-toggle="popover">
            <input type="text" class="form-control form-group col-md-4 required" value="{{old('city')}}" required autocomplete="city"  id="city" name="city" placeholder="Ciudad" data-placement="top" data-toggle="popover">
            <input type="text" class="form-control form-group col-md-4" value='Argentina' hidden  required autocomplete="country"  id="country" name="country" placeholder="Pais" data-placement="top" data-toggle="popover">
          </section>


          <h2>Area</h2>
          <section class="areaForm">
              <select disabled name="specialty_id" id="specialty_id" class="form-control form-group show-tick col-md-4 required" name="specialty_id" value="{{old('specialty_id')}}" required autocomplete="specialty_id" data-placement="top" data-toggle="popover">
              <option value="0" class="titleCat"> Especialidad </option>
              </select>
              <input type='text' class='form-control form-group show-tick col-md-4' id='license_number' name='license_number' placeholder='Numero de Matrícula' value='{{old('license_number')}}' hidden data-placement="top" data-toggle="popover">
                <input type="text" class=" form-control  show-tick col-md-4 required" id="cuit" name="cuit" placeholder="CUIT" value="{{old('cuit')}}" required>
          </section>

          <h2>Servicio</h2>
          <section class="serviceForm">
              <h5>Indica la duracion de cada turno </h5>
              <select class="form-control form-group show-tick col-md-4 required" name="appointment_duration" value="{{old('appointment_duration')}}" id="appointment_duration" data-placement="top" data-toggle="popover">
                <option value="" selected disabled>Seleccionar</option>
                <optgroup label="______________">
                <option value="5">5 Minutos</option>
                <option value="10">10 Minutos</option>
                <option value="15">15 Minutos</option>
                <option value="20">20 Minutos</option>
                <option value="30">30 Minutos</option>
                <option value="60">1 Hora</option>
              </optgroup>
              </select>
              <h5>Indica que dia comienzan tus turnos</h5>
                <input type="date" class="form-control col-md-4 required" name="date_start" value="{{old('date_start')}}" id="date_start" data-placement="top" data-toggle="popover">
            {{-- <h5>Selecciona todos los servicios que prestes </h5>
            <div class="funkyradio" id="checkbox_service">
            </div> --}}
          </section>

          <h2>Horario</h2>
          <section class="scheduleForm" id="scheduleForm" >
              <div class="well well-sm text-center my-5">
                  <h6>Elije tus dias y horarios disponibles</h6>
                  <div class="btn-group" data-toggle="buttons">
                    @foreach ($weekDays as $key => $value)
                    <div class="weekDay {{ $key }} {{  $value }}">
                      <label class="btn btn-primary col-2 disabled">
                        <input type="text" id="{{ $value }}" name="days[{{ $key }}][open]" value="0" hidden data-placement="top" data-toggle="popover">
                        <div class="">
                          <span>{{ substr($value,0,3)}}</span>
                        </div>
                      </label>
                      <div id="{{ $key }}" class="{{ $key }}Schedule  col-10 row">
                      <select name="days[{{ $key }}][open_hour][]" id="days{{ $key }}open_hour0" class=" form-control show-tick col-12 open_hour"  required autocomplete="" data-placement="top" data-toggle="popover">
                          <option value="closed" > Closed </option>
                          <option value="24hours"> 24 Horas </option>
                        <optgroup label="Horario apertura"></optgroup>
                          @php
                          for ($i = 0; $i < 24; $i++) {
                            if($i < 10 ) {
                             $option = "<option value='0$i:00:00'>0$i:00</option> <option value='0$i:30:00'>0$i:30</option>";
                            } else {
                             $option = "<option value='$i:00:00'>$i:00</option> <option value='$i:30:00'> $i:30</option>";
                            }
                           echo $option;
                          }
                          @endphp
                      </select>
                      </div>
                    </div>
                  @endforeach
                  </div>
              </div>
          </section>
      </div>
  </form>
@endsection
