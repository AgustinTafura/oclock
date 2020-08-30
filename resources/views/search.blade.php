@extends('layouts.app')



@section('scripts')
<script type="text/javascript" defer>



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

function getCity(){
  $.ajax({
    url : "getCities",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type : 'GET',
    success : function(cities) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
      $.each(cities, function(index,city){
      name = (city.name).replace(/\b\w/g, l => l.toUpperCase())
      id= name.replace(/ /g, "")
      authUserCity = ($('#id')[0].attributes['value'].value) ? ($('#id')[0].attributes['value'].value).replace(/\b\w/g, l => l.toUpperCase()).replace(/ /g, "") : 0;
      if (authUserCity && authUserCity == id) {
        $('#city').append(
          "<option selected id='"  + id + "' value='"  + name + "'>"   + name +  "</option>"
        )
      } else{
        $('#city').append(
        "<option id='"  + id + "' value='"  + name + "'>"   + name +  "</option>"
        )
      }})
    },
    error : function(xhr, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
      // alert('Disculpe, existió un problema con el Address. Intente más tarde');
    },
    complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
      // alert('Petición realizada');
    }
  });
}

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

function datalistSearcher(element){
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
      "category_id_min": min,
      "category_id_max": max,
    },
    success : function(response) {             // la respuesta es pasada como argumento a la función // código a ejecutar si la petición es satisfactoria;
      $.each(response['providers'], function(index,provider){
          $($('datalist')[0].children).each(function(i,dataLisOption){
            if($(dataLisOption)[0].attributes.name.value == provider.id){
              dataLisOption.remove()
            }
          })
          $('datalist').append(
          "<option name='" + provider.id + "' class='providers' value='" + provider.surname+ ',' +provider.name + "'>"+ provider.specialty + "</option>"
        )
      })
      $.each(response['companies'], function(index,company){
        $($('datalist')[0].children).each(function(i,dataLisOption){
          if($(dataLisOption)[0].attributes.name.value == company.id){
            dataLisOption.remove()
          }
        })
        $('datalist').append(
          "<option  name='" + company.id + "'  class='companies' value='" + company.name + "'>"+ company.street +" "+ company.number + "</option>"
        )
      })
      $.each(response['neighborhood'], function(index,neighborhood){
        $($('datalist')[0].children).each(function(i,dataLisOption){
          if($(dataLisOption)[0].attributes.name.value == neighborhood.id){
            dataLisOption.remove()
          }
        })
        $('datalist').append(
          "<option  name='" + neighborhood.id + "'  class='addresses' value='" + neighborhood.name + "'>"+ neighborhood.city + "</option>"
        )
      })



    },
    error : function(xhr, status) { // código a ejecutar si la petición falla;// son pasados como argumentos a la función // el objeto de la petición en crudo y código de estatus de la petición
    },
    complete : function(xhr, status) {             // código a ejecutar sin importar si la petición falló o no
    }
  });
}

function removeChilds(element){
  $.each($(element).children(),function(i, child){
      child.remove()
  });
}



$(function(){

  $('#dateStart').css({'padding-right':'0'})

  $('#input_datalist').on('keyup', function(e){
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
     if (this.value.length >2) {
      datalistSearcher(this)
    } else {
      removeChilds($('datalist'));
    }
    })

  $('#datalist').prop('display', 'none');

  $('form').submit(function(e){
    e.preventDefault()
    $.each($('#datalist').children(), function(index,option){
      if (option.value == $( "#input_datalist")[0].value) {
        classCat = option.attributes['class'].nodeValue
        $('#input_datalist').attr('name', "input_datalist['" + classCat +"']")
        id = $('#datalist').children()[index].attributes['name'].value
        $('form').append(
          "<input hidden id='id' name='id' value='" + id + "'> </input>"
        )
      }
    })

    if($('#specialty_id')[0].value > 0
      || ("input_datalist['providers']" === $("#input_datalist")[0].attributes[0].nodeValue
      || "input_datalist['companies']" === $("#input_datalist")[0].attributes[0].nodeValue
      // || "input_datalist['addresses']" === $("#input_datalist")[0].attributes[0].nodeValue && $('#specialty')[0].value > 0
    ))
    {
        this.submit()
    } else {
      ($('#category_id')[0].value > 0)?0:$('#category_id').focus();
      ($('#specialty_id')[0].value > 0)?0:$('#specialty_id').focus();

    }
  })

  $("#category_id").change(
    function(){
      var cat_id = $("#category_id")[0].value;

      if(this.value != 0){
        $("#specialty_id").removeAttr("disabled")
        showSpecialties(cat_id)
      } else{
        $("#specialty_id")[0].value = "0"
        $("#specialty_id").attr("disabled", "disabled")
        $("#specialty_id").html("<option value='0' > Especialidad </option>")
      }
    }
  )

  getCity()
  getCategory()
  today = new Date(Date.now())
  d = (today.getDate()<10)? "0" + today.getDate() : today.getDate()
  m = (today.getMonth()<9)? "0" + (today.getMonth() + 1) : today.getMonth() + 1
  y = today.getFullYear()
  date = y + "-" + m + "-" + d
  console.log(date);
  $('#dateStart').attr('min', date)
  // $('#dateStart').attr('min', Date.now())

  $('#specialty_id, #category_id').change(function(){
    removeChilds($('datalist'))
    $('#input_datalist')[0].value = ''
  })


  @error ('emptySearch')
  $('#exampleModal').modal('show')

  $('#exampleModal').on('hide.bs.modal', function (e) {
    console.log('MODAL OUTTT 1111111111111');
    $('#category_id').val({{old('category_id')}});
    $("#specialty_id").removeAttr("disabled")
    showSpecialties($('#category_id').val())
    $('#city').val("{{old('city')}}");

    $('#category_id').val({{old('category_id')}});
    $('#timeStart').val("{{old('timeStart')}}");
    $('#timeEnd').val("{{old('timeEnd')}}");
    $('#dateStart').val("{{old('dateStart')}}");

  })


  $('#exampleModal').on('hidden.bs.modal', function (e) {
    console.log('MODAL OUTTT 2222222222222');
    $('#specialty_id').val({{old('specialty_id')}});


  })
  @enderror

})
</script>
@endsection

@section('content')

    <span hidden disabled id='id' value='@if (Auth::user()->address) {{Auth::user()->address->city}} @endif'></span>  {{-- Esta bien hacer esto para pasar obtener los datos en JS ?????? --}}

    @error('emptySearch')
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: palevioletred; color: white;">
              <h5 class="modal-title" id="exampleModalLabel">  :( </h5>
              {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{$message}}
            </div>
          </div>
        </div>
      </div>
    @enderror


<form class="" action="{{route('searchAvailableBookings')}}" method="post">
  @csrf
  <div class="row">
    <section class="col-12">
      <select name="city" id="city" class=" form-control form-group form-group  col-md-5 @error('city') is-invalid @enderror" value="{{old('city')}}">
      </select>
      <select name="category_id" id="category_id" class=" form-control form-group  col-md-5 @error('category_id') is-invalid @enderror" value="{{old('category_id')}}">
        <option value="0" class="titleCat"> Categoría </option>
      </select>
      <select disabled name="specialty_id" id="specialty_id" class="form-control form-group  col-md-5 @error('specialty_id') is-invalid @enderror" name="specialty_id" value="{{old('specialty_id')}}">
        <option value="0" class="titleCat"> Especialidad </option>
      </select>
      <label class="col-3 col-md-3 d-md-block "for="">Horario:</label>
      <select name="timeStart" id="timeStart" class=" form-control form-group show-tick col-4 col-md-2 d-inline  timeStart @error('timeStart') is-invalid @enderror"   autocomplete="" value="{{old('timeStart')}}">
        @for ($i = 0; $i < 24; $i++)
          @if ($i < 10 )
            <option value='0{{$i}}:00:00'>0{{$i}}:00</option>{{--  <option value='0{{$i}}:30:00'>0{{$i}}:30</option> --}}
          @else
            <option value='{{$i}}:00:00'>{{$i}}:00</option> {{-- <option value='{{$i}}:30:00'> $i:30</option> --}}
          @endif
        @endfor
      </select>
      <select name="timeEnd" id="timeEnd" class=" form-control form-group show-tick col-4 col-md-2 d-inline  timeEnd @error('timeEnd') is-invalid @enderror"   autocomplete="" value="{{old('timeEnd')}}">
        <option value='23:59:00'>23:59</option>
        @for ($i = 23; $i > 0; $i--)
          @if ($i < 10 )
            <option value='0{{$i}}:00:00'>0{{$i}}:00</option>{{--  <option value='0{{$i}}:30:00'>0{{$i}}:30</option> --}}
          @else
            <option value='{{$i}}:00:00'>{{$i}}:00</option> {{-- <option value='{{$i}}:30:00'> $i:30</option> --}}
          @endif
        @endfor
      </select>

      <label class="col-6 col-md-3 d-inline d-md-block" for="">A partir del dia:</label>
      <input type="date" name="dateStart" class="form-control form-group col-6 col-md-3 d-inline"  id="dateStart"  placeholder="2020-04-27" value="{{date('Y-m-d')}}">

      <label class="col-3 col-md-3 d-md-block" for="">Opcional:</label>
      <input name="" id="input_datalist" list="datalist" class="form-control form-group show-tick col-md-5" placeholder="Apellido de Profesional, Clinica o Barrio" autocomplete="off">
      <datalist name='datalist' id="datalist">
      </datalist>

      <button type="submit" name="`submit"  class="btn btn-primary col-md-5 " >Buscar</button>

    </section>


  </div>
</form>
@endsection
