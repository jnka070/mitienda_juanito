window.addEventListener("DOMContentLoaded", function(){
       
    let $form = document.querySelector("#pay");
    $form.addEventListener("submit", function(e){
        e.preventDefault();
        console.log("boton cargado");
        let datos = new FormData($form);
        let datosParse = new URLSearchParams(datos);
        var respuesta;
        var div_respuesta = document.querySelector("#respay");
        
        
        fetch(location.protocol + '//' + location.host + '/wp-json/iq/button/',
            {
            method: 'POST',
            
            body: datosParse,

        })
        .then(res=> res.json())
        .then(dataJson => {
            
            
           respuesta = dataJson;
           console.log(respuesta);
          if(respuesta.success){
            console.log("Verdadero");
            console.log(respuesta.mensaje);
            document.querySelector("#pay").style.display = 'none';
            let mensaje = document.createElement('h2');
            mensaje.innerHTML = respuesta.mensaje;
            div_respuesta.appendChild(mensaje);
            let receren = document.createElement('h2');
            receren.innerHTML ='numero de referencia ' + respuesta.recerence;
            div_respuesta.appendChild(receren);
            let orden = document.createElement('h2');
            orden.innerHTML = 'numero de orden ' + respuesta.Orden_Data;
            div_respuesta.appendChild(orden);
            let monto = document.createElement('h2');
            monto.innerHTML = 'numero de orden ' + respuesta.Amount + ' Bs';
            div_respuesta.appendChild(monto);
            
           
            
          }else{
            console.log("falso");
            console.log(respuesta.mensaje);
            let mensaje = document.createElement('h2');
            mensaje.innerHTML = respuesta.mensaje;
            div_respuesta.appendChild(mensaje);
          }
           
               return dataJson.datosParse;
        })
        .catch(err => {
            console.log(`Hay un error: ${err}`)
        })

    })
 
});


