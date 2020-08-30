
@extends('layouts.app')
@section('styles')
  {{-- <link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>  para bootstrap Plugin
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />  para bootstrap Plugin --}}
  <link href="{{ asset('fullcalendar/core/main.css')}}" rel="stylesheet" />
  <link href="{{ asset('fullcalendar/daygrid/main.css')}}" rel="stylesheet" />
  <link href="{{ asset('fullcalendar/list/main.css')}}" rel="stylesheet" />
  <link href="{{ asset('fullcalendar/timegrid/main.css')}}" rel="stylesheet" />
  {{-- <link href="{{ asset('fullcalendar/bootstrap/main.css')}}" rel="stylesheet" />  para bootstrap Plugin --}}
@endsection

@section('scripts')
  <script src="{{ asset('fullcalendar/core/main.js')}}"defer></script>
  <script src="{{ asset('fullcalendar/moment/main.js')}}"defer></script>
  <script src="{{ asset('fullcalendar/interaction/main.js')}}"defer></script>
  <script src="{{ asset('fullcalendar/daygrid/main.js')}}"defer></script>
  <script src="{{ asset('fullcalendar/list/main.js')}}"defer></script>
  <script src="{{ asset('fullcalendar/timegrid/main.js')}}"defer></script>
  <script src="{{ asset('fullcalendar/bootstrap/main.js')}}"defer></script>
  {{-- <script src="https://unpkg.com/@popperjs/core@2" defer></script> --}}
  {{-- <script src="{{ asset('fullcalendar/core/locales/es.js')}}"defer></script>    PARA USAR lOCALE:ES--}}

  <script type="">
  $(function() {
    var calendarEl = $('#calendar')[0];

    var calendar = new FullCalendar.Calendar(calendarEl, {
      // themeSystem: 'bootstrap', //para bootstrap Plugin
      plugins: [ 'list', 'dayGrid', 'timeGrid' ,'interaction', 'bootstrap', 'moment' ],
      views: {
        eventLimit: true,
        dayGridMonth:{
          eventLimit: 2
        }
      },
      locale: 'es',
      validRange: function(nowDate) { //determina al rango valido
        return {
          start: nowDate,
          // end: nowDate.clone().add(1, 'months')
        }
      },

      // allDaySlot: false, //elimina el slot All-day del view timeGridWeek
      allDayText: 'holaa',   //texto que se desea poner en el slot All-day del view timeGridWeek
      slotLabelFormat: { // da formato al texto de los titulos de filas y columnas
        hour: '2-digit',
        minute: '2-digit',
        omitZeroMinute: false,
        // meridiem: 'short'
      },
      minTime: "08:00:00", // hora desde que empieza la grilla
      maxTime: "20:00:00", // hora desde que finaliza la grilla
      // columnHeaderFormat: {},    // formato de los encabezados de las grillas columnas
      viewSkeletonRender: function(info){ // se activa al pasar de una vista a otra
        console.log(info.view.type) // trae el tipo de vista
        console.log(calendar.view);
      },
      fechasRender: function(info){ // se activa
        console.log(info) // trae el tipo de vista
      },
      defaultView: 'timeGridWeek',
      header: {
        left: 'prev,next, today, listDay',
        center: 'title',
        right: 'dayGridMonth, timeGridWeek, timeGridDay',
      },
      height: 'parent', // 'auto,' // que tome la altura de su contenedor padre
        // contentHeight: '50%', // altura del contenido
      // selectable: 'true', // hacer que sean seleccionables los slots vacios
      // selectMirror: 'true', //seleccionar slots de tiempo
      slotDuration: '00:20:00', //La frecuencia para mostrar franjas horarias.
      // eventColor: 'yellow',
      // editable: 'true',
      eventSources: [
        {
          url: '/booking/35', // use the `url` property
          // color: 'palevioletred',    // an option!
          textColor: 'black'  // an option!
        },
        // {
        //     title: 'sdkfjhskdjfh',
        //     start: '2020-04-24 08:00:00',
        //     end: '2020-04-24 08:20:00',
        //       backgroundColor: 'palevioletred',    // an option!
        //       // rendering: 'background',
        //   }
      ],
      // events: '/booking/35',

      navLinks: 'true',
      // businessHours:{}, // para setear las horas y dias de trabajo habilidatas
      nowIndicator: true,
      selectable: true,
      // select: function(info) {
          // calendar.eventMouseEnter()
        // alert('selected ' + info.startStr + ' to ' + info.endStr);
      // },
      // selectOverlap: function(info) {
        // info.setProp('backgroundColor', 'yellow')
        // info.setProp('backgroundColor', 'yellow')
        // console.log(info);
        // info.setProp('backgroundColor', 'yellow')
        // return event.rendering === 'background';
      // },
      // selectAllow: function(info){
      //   console.log(info);
      // },
      eventMouseEnter: function(info){
        info.el.style.cursor = 'pointer'
        console.log(info)
      //   // info.event.element.setProp('class', 'tooltip')
      //   var tooltip = Popper.createPopper(info.el,$('#exampleModal').modal(), {
      //     title: info.event.title,
      //     placement: 'left',
      //     trigger: 'hover',
      //     container: 'body'
      //   })
      //   console.log($('exampleModal'));
      //     // info.event.setProp('backgroundColor', 'yellow')
      },
      // eventRender: function(info) {
      //   console.log('asdasdasd');
      // },
      longPressDelay: 2000,
      eventLongPressDelay: 3000,
      selectLongPressDelay: 4000,
      eventClick: function(info) {
        $('#exampleModal').modal()
        $('#exampleModal h5')[0].innerText = "Titulo Evento"
        console.log('{{Auth::user()->provider->address->company->name}}')
        console.log(info);
        $('#provider_id').val({{Auth::user()->provider->id}})
        $('#status_id').val(info.event.title)
        hourStart =("0" + info.event.start.getHours()).slice(-2)+":"+("0" + info.event.start.getMinutes()).slice(-2);
        hourEnd =("0" + info.event.end.getHours()).slice(-2)+":"+("0" + info.event.end.getMinutes()).slice(-2);
        $('#start_time').val(hourStart)
        $('#end_time').val(hourEnd)
        $('#active').val(info.event.active)
        // info.event.setProp('backgroundColor', 'yellow')

        // console.log(calendar.getEventById('1')) // obtengo el evento por ID
      },

      eventRender: function(info){
        // console.log(info.event.getResources());
        if(info.event.extendedProps.resourceId == 3){
          if(info.event.backgroundColor == ''){
            info.event.setProp('borderColor', 'secondary')
            info.event.setProp('backgroundColor', 'green')
          }
          // console.log(info)
          // info.el.style.backgroundColor = 'blue'
          // info.el.style.borderColor = 'blue'
        }
      },
      dateClick: function(info) {
        // console.log(info)
        if(!info.allDay){
          $('#exampleModal').modal()

          $('#exampleModal h5')[0].innerText = "Titulo del Modal para la Fecha"
          // $('#start_time').val(info.dateStr) // Asigna valores a los input del Modal
        } else {
          console.log(info.dateStr)
          console.log('2020-05-01');
          calendar.changeView('timeGridDay')
          calendar.gotoDate(info.dateStr)
        }
      },

      // eventRender: function(info) {
      //     var tooltip = new Tooltip(info.el, {
      //       title: info.event.extendedProps.description,
      //       placement: 'top',
      //       trigger: 'hover',
      //       container: 'body'
      //     });
      // },


    });
    calendar.render();
    // calendar.eventMouseover()

    // console.log(calendar.getResources())

    $('#calendar').on('touchstart', function(e) {
      var swipe = e.originalEvent.touches
      start = swipe[0].pageX
      distance = 0
      $('#calendar').on('touchmove', function(e) {
        var contact = e.originalEvent.touches
        end = contact[0].pageX
        distance = end-start

      }).one('touchend', function() {
        if(typeof distance !== 'undefined' && (distance > 60 || distance<-60)){
          if(distance > 60){
            calendar.prev();
          }
          if(distance < -60){
            calendar.next()
          }
          $('#calendar').off('touchmove touchend');
        }
      })
    })
    // calendar.optionsManager.overrides.header.setProp(left, '')
    // calendar.setOption('header' ,{
    //     left: '',
    //     center: 'title',
    //     right: 'dayGridMonth, timeGridWeek, timeGridDay',
    // },)


  })

  </script>
@endsection

@section('content')
<i class="fas fa-forward"></i>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div >
        <div class="modal-body row">
          {{-- <div class="container-fluid row"> --}}
          <div class="col-12">
            <label for="provider_id" class="col-4 col-md-3">Doc/Od:</label><input type="text"  name="provider_id" class="form-control d-inline-block col-8 col-md-9" id="provider_id">
          </div>
          <div class="col-12">
            <label for="service_id" class="col-4 col-md-3">Servicio:</label><input type="text"  name="service_id" class="form-control d-inline-block col-8 col-md-9" id="service_id">
          </div>
          <div class="col-12">
            <label for="status_id" class="col-4 col-md-3">Estado:</label><input type="text"  name="status_id" class="form-control d-inline-block col-8 col-md-9" id="status_id">
          </div>
          <div class="col-12">
            <label for="start_time" class="col-4 col-md-3">Inicio:</label><input type="text"  name="start_time" class="form-control d-inline-block col-8 col-md-9" id="start_time">
          </div>
          <div class="col-12">
            <label for="end_time" class="col-4 col-md-3">Fin:</label><input type="text"  name="end_time" class="form-control d-inline-block col-8 col-md-9" id="end_time">
          </div>
          <div class="col-12">
            <label for="active" class="col-4 col-md-3">Activo</label><input type="text"  name="active" class="form-control d-inline-block col-8 col-md-9" id="active">
          </div>

          {{-- </div> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Udate</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
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
