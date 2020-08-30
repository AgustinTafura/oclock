@extends('layouts.app')
@section('styles')
{{-- <link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>  para bootstrap Plugin
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />  para bootstrap Plugin --}}
<link href="{{ asset('fullcalendar/core/main.css')}}" rel="stylesheet" />
<link href="{{ asset('fullcalendar/daygrid/main.css')}}" rel="stylesheet" />
<link href="{{ asset('fullcalendar/list/main.css')}}" rel="stylesheet" />
<link href="{{ asset('fullcalendar/timegrid/main.css')}}" rel="stylesheet" />
<script src="https://kit.fontawesome.com/01449c785e.js" crossorigin="anonymous" defer></script>

{{-- <link href="{{ asset('fullcalendar/bootstrap/main.css')}}" rel="stylesheet" /> para bootstrap Plugin --}}
@endsection

@section('scripts')
<script src="{{ asset('fullcalendar/core/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/moment/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/interaction/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/daygrid/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/list/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/timegrid/main.js')}}" defer></script>
<script src="{{ asset('fullcalendar/bootstrap/main.js')}}" defer></script>

{{-- <script src="https://unpkg.com/@popperjs/core@2" defer></script> --}}
{{-- <script src="{{ asset('fullcalendar/core/locales/es.js')}}"defer></script> PARA USAR lOCALE:ES--}}



<script type="" defer>
  var weekday = new Array(7);
  weekday[0] = "Domingo";
  weekday[1] = "Lunes";
  weekday[2] = "Martes";
  weekday[3] = "Miercoles";
  weekday[4] = "Jueves";
  weekday[5] = "Viernes";
  weekday[6] = "Sabado";

  var months = new Array(12);
  months[0] = "Enero";
  months[1] = "Febrero";
  months[2] = "Marzo";
  months[3] = "Abril";
  months[4] = "Mayo";
  months[5] = "Junio";
  months[6] = "Julio";
  months[7] = "Agosto";
  months[8] = "Septiembre";
  months[9] = "Octubre";
  months[10] = "Novimebre";
  months[11] = "Diciembre";


     user_id = {{ Auth::user()->id }}
    // console.log(user_id);
    $(function() {
      customPositionFooter();

      var calendarEl = $('#calendar')[0];
      var providers = []
      // var providersRendered = []
      var calendar = new FullCalendar.Calendar(calendarEl, {

        plugins: [ 'list', 'dayGrid', 'timeGrid' ,'interaction', 'bootstrap', 'moment'  ],

        eventLimit: 1,

        defaultView: 'listDay',

        views: {
          eventLimit:true,
          dayGridMonth:{
            eventLimit: 1,
            eventLimitClick: "day",
            eventLimitText: "Turnos",
            titleFormat: { year: 'numeric', month: 'short',},
                    // timeZone: 'UTC',
          },
        },
        // footer: {
        //   // center: 'today',
        // },
        titleFormat: { year: 'numeric', month: 'short', day: '2-digit' },

        defaultDate: '{!!$dateSelected!!}',

        // locale: 'es',

        minTime: "08:00:00", // hora desde que empieza la grilla

        maxTime: "20:00:00", // hora desde que finaliza la grilla

        slotDuration: '00:15:00', //La frecuencia para mostrar franjas horarias.

        height: 'auto', // 'parent,' // que tome la altura de su contenedor padre

        eventSources: [
          {
          events:{!!$bookings->toJson()!!},
          }
        ],

        navLinks: 'true',
        // slotLabelFormat: { // da formato al texto de los titulos de filas y columnas
        //   hour: '2-digit',
        //   minute: '2-digit',
        //   omitZeroMinute: false,
        //   // meridiem: 'short'
        // },
        // noEventsMessage: "No hay turnos disponibles en esta Fecha",

        header:{
            // left: 'prev',
            // center: 'title, dayGridMonth, today' ,
            // right: 'next,',
            left: 'search',
            center: 'title' ,
            right: 'dayGridMonth',
        },

        fixedWeekCount: false,

        customButtons: {
          search: {
            text: 'Nueva Búsqueda',
            click: function() {
              window.location.href = "http://localhost:3000/search";
            }
          }
        },

        validRange: function(nowDate) { //determina al rango valido
          return {
            start: nowDate,
            // end: nowDate.clone().add(1, 'months')
          }
        },

        dateClick: function( dateClickInfo ) {
          console.log(dateClickInfo);
        },


        // FIRST RUN ON VIEW CHANGE -
        datesDestroy: function(info){
          console.log('dateDestroy - 1')
          providers = []
          $('.provider').remove()
          $('#emptyDay').remove()
        },

        // SECOND RUN
        eventRender: function (info){
          console.log('eventRender - 2');
          if(info.view.type === 'listDay'){
            if (!providers[info.event.groupId]){
              providers[info.event.groupId] = {
                title : info.event.title,
                name : info.event.extendedProps.name,
                surname : info.event.extendedProps.surname,
                booking : {
                  id : [info.event.id],
                  start :  [info.event.start],
                  end :  [info.event.end],
                },
                specialties : info.event.extendedProps.specialties,
                companyName : info.event.extendedProps.companyName,
                address: info.event.extendedProps.completeAddress,
              }
            } else {
              providers[info.event.groupId].booking.id.push(info.event.id)
              providers[info.event.groupId].booking.start.push(info.event.start)
              providers[info.event.groupId].booking.end.push(info.event.end)
            }
          }

        },

        // THIRD RUN
        viewSkeletonRender: function(info){ // se activa al pasar de una vista a otra
          console.log('viewSkeletonRender - 3');
          if(info.view.type === 'dayGridMonth'){
            $('footer').css({ bottom : "AUTO"});
            $('.fc-dayGridMonth-button').attr('hidden', true)
            $('.fc-list-button').attr('hidden', true)
            $('.fc-more').html('Turnos')
          } else {
            $('footer').css({ bottom : "0"});
            if(!$('.fc-list-empty').length){
              $('footer').css({ bottom : "AUTO"});
            }

            $(info.el).remove();
            console.log(info);
          }
        },

        // FOURTH RUN
        datesRender: function(info){ // se activa al clickear next o prev
          console.log('DATESrENDER - 4');
          $('.fc-dayGridMonth-button').html('')
          $('.fc-dayGridMonth-button').append('<i class="far fa-calendar-alt"></i>')

          $('.fc-search-button').html('')
          $('.fc-search-button').append('<i class="fas fa-search"></i>')

          $('.fc-left').addClass('col-2')
          $('.fc-right').addClass('col-2')
          console.log('DATESrENDER - 4  bbbbbbbbbbbb');
          if(info.view.type === 'dayGridMonth'){
            $('.fc-dayGridMonth-button').html('')
            $('.fc-dayGridMonth-button').append('<i class="far fa-calendar-alt"></i>')

            $('.fc-search-button').html('')
            $('.fc-search-button').append('<i class="fas fa-search"></i>')

            $('.fc-left').addClass('col-2')
            $('.fc-right').addClass('col-2')
            $('footer').css({ bottom : "AUTO"});
            $('.fc-dayGridMonth-button').attr('hidden', true)
            $('.fc-list-button').attr('hidden', true)
            $('.fc-more').html('Turnos')
          } else if (info.view.type === 'listDay') {
            $('.fc-dayGridMonth-button').html('')
            $('.fc-dayGridMonth-button').append('<i class="far fa-calendar-alt"></i>')

            $('.fc-search-button').html('')
            $('.fc-search-button').append('<i class="fas fa-search"></i>')

            $('.fc-left').addClass('col-2')
            $('.fc-right').addClass('col-2')
            if(!$('.fc-list-empty').length){
              $('footer').css({ bottom : "AUTO"});
              $.each(providers, function( index, providerObj ) {
                if(providerObj) {
                  $('.fc-view-container').append('<div class="provider" id="' + index + '"></div>')
                  $('#' + index +'').append('<div class="providerInfo  row container-fluid"></div><div class="boxTime container-fluid"><div class="availableHours" ></div>')

                    // <div class="btn btn-secondary arrow-btn"><span class="fc-icon fc-icon-chevrons-left arrow-icon"></span></div>
                    // <div class="btn btn-secondary arrow-btn"><span class="fc-icon fc-icon-chevrons-right arrow-icon"></span></div></div>
                  $('#' + index +'> .providerInfo ').append('<div class="icon row col-4"><img alt="" /></div>')
                  $('#' + index +'> .providerInfo > div > img ').attr('src', '{{asset('storage/img/dentistBoy.png')}}')
                  $('#' + index +'> .providerInfo ').append('<div class="info row col-6"></div>')
                  $('#' + index +'> .providerInfo > .info ').append('<div class="name">' +  providerObj.title  + '</div>')
                  $('#' + index +'> .providerInfo > .info ').append('<div class="companyName">' +  providerObj.companyName  + '</div>')
                  $('#' + index +'> .providerInfo > .info ').append('<div class="specialities">' +  providerObj.specialties  + '</div>')
                  $('#' + index +'> .providerInfo > .info ').append('<div class="address">' +  providerObj.address  + '</div>')

                  // console.log(providerObj.booking.start.length);
                  // console.log(providerObj.booking.id.length);
                  for (i = 0; i < providerObj.booking.start.length; i++) {
                    hour = ( providerObj.booking.start[i].getHours() <10 ) ? '0'+providerObj.booking.start[i].getHours() : providerObj.booking.start[i].getHours();
                    min = ( providerObj.booking.start[i].getMinutes() <10 ) ? '0'+providerObj.booking.start[i].getMinutes() : providerObj.booking.start[i].getMinutes();
                    $('#' + index +'> .boxTime > .availableHours ').append('<a id="' + providerObj.booking.id[i] + '" class="startTime btn btn-primary">' + hour + ' : ' + min + '</a>')
                  }
                }
              });

              var allCalendarEventsRendered = info.view.context.theme.calendarOptions.eventSources[0].events

              $.each($('.startTime '), function(i,elem){
                $(elem).click(function(){

                  $('#bookingModal').modal('show')
                  bookingSelected = calendar.getEventById( elem.id )
                  console.log(bookingSelected);
                  $('#bookingModal #doc_name.modal-title').append(bookingSelected.title)
                  $('#bookingModal #doc_company.modal-title').append(bookingSelected._def.extendedProps.companyName)
                  $('#bookingModal #doc_address.modal-title').append(bookingSelected._def.extendedProps.completeAddress)

                  day = weekday[bookingSelected.start.getDay()]
                  dayNum = bookingSelected.start.getDate()
                  month = months[bookingSelected.start.getMonth()]
                  hour = (bookingSelected.start.getHours()<10)?bookingSelected.start.getHours():bookingSelected.start.getHours()
                  min = (bookingSelected.start.getMinutes()<10)?'0'+bookingSelected.start.getMinutes():bookingSelected.start.getMinutes()
                  booking_id = bookingSelected.id
                  console.log(bookingSelected);
                  $('#bookingModal #booking_date').append(day + " " + dayNum + " de " + month + ", " + hour + ":" + min  + " hs " )

                  // console.log(elem.id);
                  // console.log(calendar.getEvents());
                  // console.log(calendar.getEventById( elem.id ));
                  // console.log(calendar.getEventSources());



                })
              })

              // $('.fc-view-container').html(calendar.getEvents())
              if(!info.view.eventRenderer.segs.length){
                console.log('VACIOOOOO');
                $('.fc-view-container').append('<div class="" id="emptyDay"></div>')
                $('#emptyDay').append('<div class="" id="emptyMessage">No hay turnos disponibles en esta Fecha</div>')
                // $('#emptyDay').append('<div class="" id="emptyOptions">Desliza para ver el siguiente día</div>')
                $('#emptyDay').append('<div><button id="nextAvailableDate" type="button" class="fc-button fc-button-primary">Próximo Turno Disponible</button></div>')

                dateEventsRendered = []
                currentDate = new Date(info.view.activeStart)
                nextDate = currentDate.getTime() +86400000

                $('#nextAvailableDate').click(function(i,e){
                  $.each(allCalendarEventsRendered, function(i,e) {
                    date = new Date(e.start)
                    empty = true
                    if (date >= nextDate) {
                      calendar.gotoDate(date)
                      empty = false;
                      return empty;
                    }
                  })
                  if(empty) {
                    $('#emptySearch_NextDay').modal('show')
                  }



                })

              }
              console.log(new Date(info.view.context.theme.calendarOptions.eventSources[0].events[0].start).getTime());
              currentDate = new Date(info.view.activeStart);
              currentDate.getDate()
              // console.log(currentDate + 1);
              console.log(currentDate.getTime() +86400000)
              console.log(new Date("2020-06-18 00:00:00").getTime())


              console.log('daterender');
              // console.log(providers);
            }

          }

          customPositionFooter();
        },

      })

      // -------------------------------------------------------------------  Events  -------------------------------------------------------------------------

      calendar.render();
      $('#principalContainer').removeClass('container')
      $('#principalContainer').addClass('container-fluid')
      $('main').removeClass('py-4')
      $('main').addClass('pt-sm-4')

      $('#calendar').on('touchstart', function(e) {
        var swipe = e.originalEvent.touches
        target = e.target
        start = swipe[0].pageX
        distance = 0
        $('#calendar').on('touchmove', function(e) {

          var contact = e.originalEvent.touches
          end = contact[0].pageX
          distance = end-start

        }).one('touchend', function() {
          if(typeof distance !== 'undefined' && (distance > 60 || distance<-60)){
            if(!$(target).hasClass( "startTime" ) && !$(target).hasClass( "availableHours" ) && !$(target).hasClass( "boxTime" ) ){
              if(distance > 60){
                calendar.prev();
              }
              if(distance < -60){
                calendar.next()
              }
              $('#calendar').off('touchmove touchend');
            }
          }
        })
      })

      $('#bookingModal .modal-body').change(function(e){
        empty = 0;
        $.each($('.patient-info'), function(index, input){
          if(!input.value) {
            empty = 1
            return false
          }
        })
        if (!empty) {
          $('.modal-footer .btn-confirm').removeAttr('disabled')
        } else {
          $('.modal-footer .btn-confirm').attr('disabled', 'disabled')
        }
      })

      $('.modal-footer .btn-close').click(function(e){
        $('#doc_name').empty()
        $('#doc_company').empty()
        $('#doc_address').empty()
        $('#booking_date').empty()
      })

      $('#bookingModal').on('hidden.bs.modal', function (e) {
        $('#doc_name').empty()
        $('#doc_company').empty()
        $('#doc_address').empty()
        $('#booking_date').empty()
      })

      $("#booking-confirm").click(function(event){
        event.preventDefault()
        empty = 0;
        $.each($('.patient-info'), function(index, input){
          if(!input.value) {
            empty = 1
            return false
          }
        })
        if (!empty) {
          setBooking()
        }
      })

      $("#booking_confirmed").on('hide.bs.modal', function (e) {
        var url = "/home";
        $(location).attr('href',url);
      })

    })

    // -------------------------------------------------------------------  END Events  -------------------------------------------------------------------------

    // -------------------------------------------------------------------     Funtions -------------------------------------------------------------------------
    function customPositionFooter() {
      if (($('body').outerHeight(true)) >= $('#app').outerHeight(true)){
        $('footer').css({ bottom : "0", position: 'absolute'});
        $('footer').offset({ left: 0 })
        $('footer').width('100%');
      }
    }

    function setBooking() {
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : "/booking/"+booking_id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type : 'PUT',
        data : {   // la información a enviar
          _token: CSRF_TOKEN,
          // "name" : $('#patient_name').val(),
          // "surname" : $('#patient_surname').val(),
          // "dni" :  $('#patient_dni').val(),
          // "medical_insurance": $('#patient_medical_insurance').val(),
          // "credential_id": $('#patient_credential_id').val(),
          // "patient_confirmation":  $('#patient_confirmation').val(),
          // "confirmation_value":  $('#patient_confirmation_value').val(),
          "user_id" : user_id,
        },
        success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
          $("#bookingModal").modal('hide')
          $("#booking_confirmed").modal('show')
        },
        error : function(xhr, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
        },
        complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
        }
      });
    }


    // -------------------------------------------------------------------  END Funtions -------------------------------------------------------------------------






  </script>
@endsection

@section('content')
<div class="modal fade" id="booking_confirmed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="booking_confirmed-title" id="exampleModalLabel"> TURNO CONFIRMADO!! </h5>
                {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-footer">
              <button id="booking_confirmed-close" type="button" data-dismiss="modal" class="btn btn-secondary btn-close">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="emptySearch_NextDay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: palevioletred; color: white;">
                <h5 class="modal-title" id="exampleModalLabel"> :( </h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                No hay turno disponibles en los próximos días.
                Intenta con una Nueva Busqueda!
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div role="document" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header doc-title">
              <h5 id="doc_name" class="modal-title"></h5>
              {{-- <p id="doc_specialty" class="modal-title">Odontología en General</p> --}}
              <h6 id="doc_company" class="modal-title"></h6>
              <p id="doc_address" class="modal-title"></p>
          </div>
            <h5 id="booking_date" class="modal-subheader modal-title" style="BORDER-RADIUS: 0;BACKGROUND: #626580;padding: 1rem 1rem;"></h5>

          <div class="modal-body">
            <div class="col-12 patient-row" style="margin-top: 0.3rem;">
              <h5 class="d-inline-block col-12 col-md-9" style="text-align: center;">Datos del Paciente</h5>
            </div>
            <div class="col-12 patient-row">
              <input type="text" name="patient_name" id="patient_name" value="@auth{{ Auth::user()->name }}@endauth" placeholder="Nombre" class="form-control patient-info d-inline-block col-12" style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;">
              </div>
              <div class="col-12 patient-row">
                <input type="text" name="patient_surname" id="patient_surname" value="@auth{{(!Auth::user()->surname)?:Auth::user()->surname}}@endauth" placeholder="Apellido" class="form-control patient-info d-inline-block col-12" style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;">
              </div>
              <div class="col-12 patient-row">
                <input type="text" name="patient_dni" id="patient_dni" value="@auth{{(Auth::user()->dni)?:Auth::user()->dni}}@endauth" placeholder="DNI" class="form-control patient-info d-inline-block col-12" style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;">
              </div>
              <div class="col-12 patient-row" style="place-content: center;">
                <select name="patient_medical_insurance" id="patient_medical_insurance" class="form-control patient-info d-inline-block col-12"  style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;">
                  <option value="">Cobertur Médica</option>
                  <option value="Consulta Particular">Consulta Particular</option>
                  <option value="OSDE">OSDE</option>
                  <option value="Swiss Medical">Swiss Medical</option>
                  <option value="Wiri Salud">Wiri Salud</option>
                  <option value="Accord Salud">Accord Salud</option>
                  <option value="CASA">CASA</option>
                  <option value="Galeno">Galeno</option>
                  <option value="Medife">Medife</option>
                  <option value="OMINT">OMINT</option>
                  <option value="UPCN">UPCN</option>
                  <option value="AMFFA">AMFFA</option>
                  <option value="Centro Medico Pueyrredon">Centro Medico Pueyrredon</option>
                  <option value="Cobermed">Cobermed</option>
                  <option value="FEMEBA">FEMEBA</option>
                  <option value="Federada Salud">Federada Salud</option>
                  <option value="Luis Pasteur">Luis Pasteur</option>
                  <option value="MEDICUS">MEDICUS</option>
                  <option value="OSMECON">OSMECON</option>
              </select>
            </div>
            <div class="col-12 patient-row" style="place-content: center;">
              <input type="text" name="patient_credential_id" id="patient_credential_id" class="form-control patient-info d-inline-block col-12" placeholder="Nro. de Credencial - Opcional"  style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;">
            </div>
              <div class="col-12 patient-row">
                <select name="patient_confirmation" id="patient_confirmation" class="form-control patient-info d-inline-block col-4 col-md-3"  style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;">
                  <option value="Mail" selected>Mail</option>
                  <option value="Celular">Celular</option>
                </select>
                <input type="text" name="patient_confirmation_value" id="patient_confirmation_value"  value="@auth{{(Auth::user()->email)?:Auth::user()->email}}@endauth" class="form-control patient-info d-inline-block col-8"  style="border-top: inherit;border-right: inherit;border-left: inherit;border-radius: inherit;margin-top: 1px;">
              </div>
          </div>
          <div class="modal-footer">
            <button id="booking-confirm" type="button" class="btn btn-primary btn-confirm" disabled>CONFIRMAR</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary btn-close">CERRAR</button>
          </div>
      </div>
  </div>
</div>


{{-- <div class="row">
    <div class="col-2"></div>
    <div class="col-8"> --}}
<div id='calendar'></div>
{{-- </div>
    <div class="col-2"></div>
  </div> --}}

@endsection
