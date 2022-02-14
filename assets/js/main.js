$("document").ready(() => {
  //* Función para generar una notificación
  function notify(content, type = "success") {
    let wrapper = $(".wrapper_notifications"),
      id = Math.floor(Math.random() * 500 + 1),
      notification =
        '<div class="alert alert-' +
        type +
        '" id="noty_' +
        id +
        '">' +
        content +
        "</div>",
      time = 5000;

    //! Insertar en el contenedor la notificación
    wrapper.append(notification);

    //! Timer para ocultar las notificaciones
    setTimeout(function () {
      $("#noty_" + id).remove();
    }, time);

    return true;
  }

  //* Cargar el contenido de la cotizacion
  function get_quote() {
    let wrapper = $(".wrapper_quote"),
      action = "get_quote_res",
      cliente = $("#cliente"),
      empresa = $("#empresa"),
      email = $("#email"),
      tiempo_entrega = $("#tiempo_entrega"),
      forma_pago = $("#forma_pago"),
      telefono = $("#telefono");

    $.ajax({
      url: "ajax.php",
      type: "GET",
      cache: false,
      dataType: "json",
      data: { action },
      beforeSend: function () {
        wrapper.waitMe();
      },
    })
      .done((res) => {
        if (res.status === 200) {
          cliente.val(res.data.quote.cliente);
          empresa.val(res.data.quote.empresa);
          email.val(res.data.quote.email);
          tiempo_entrega.val(res.data.quote.tiempo_entrega);
          forma_pago.val(res.data.quote.forma_pago);
          telefono.val(res.data.quote.telefono);
          wrapper.html(res.data.html);
        } else {
          cliente.val("");
          empresa.val("");
          email.val("");
          tiempo_entrega.val("");
          forma_pago.val("");
          telefono.val("");
          wrapper.html(res.msg);
        }
      })
      .fail((err) => {
        wrapper.html("Ocurrio un error recargue la página...");
      })
      .always(() => {
        wrapper.waitMe("hide");
      });
  }

  get_quote();

  //* Funcion para agregar un concepto a la cotizacion
  $("#add_to_quote").on("submit", add_to_quote);
  function add_to_quote(e) {
    e.preventDefault();

    let form = $("#add_to_quote"),
      action = "add_to_quote",
      data = new FormData(form.get(0)),
      errors = 0;

    // Agregar la acción al objeto data
    data.append("action", action);

    // Validar el concepto
    let modelo = $("#modelo").val(),
      precio_unitario = parseFloat($("#precio_unitario").val());

    if (modelo.length < 2) {
      notify(
        "Ingresa un modelo válido por favor. (MAYOR DE 2 CARACTERES)",
        "danger"
      );
      errors++;
    }

    // Validar el precio
    if (precio_unitario < 1) {
      notify("Por favor ingresa un precio mayor a $1.00", "danger");
      errors++;
    }

    if (errors > 0) {
      notify("Completa el formulario.", "danger");
      return false;
    }

    $.ajax({
      url: "ajax.php",
      type: "POST",
      dataType: "json",
      cache: false,
      processData: false,
      contentType: false,
      data: data,
      beforeSend: () => {
        form.waitMe();
      },
    })
      .done((res) => {
        if (res.status === 201) {
          notify(res.msg);
          form.trigger("reset");
          get_quote();
        } else {
          notify(res.msg, "danger");
        }
      })
      .fail((err) => {
        notify("Hubo un problema con la petición, intenta de nuevo.", "danger");
        form.trigger("reset");
      })
      .always(() => {
        form.waitMe("hide");
      });
  }

  //* Funcion para reiniciar cotizacion
  $(".restart_quote").on("click", restart_quote);
  function restart_quote(e) {
    e.preventDefault();

    let button = $(this),
      action = "restart_quote";
      download = $('download_quote');
      generate = $('generate_quote');
      default_text = 'Generar Cotización';

    if (!confirm("Estas seguro que quieres reiniciar?")) return false;

    $.ajax({
      url: "ajax.php",
      type: "post",
      dataType: "json",
      data: { action },
    })
      .done((res) => {
        if (res.status === 200) {
          download.fadeOut();
          download.attr('href', '');
          generate.html(default_text);
          notify(res.msg);
          get_quote();
        } else {
          notify(res.msg, "danger");
        }
      })
      .fail((err) => {
        notify("Hubo un problema con la petición.", "danger");
      })
      .always(() => {});
  }

  //*Funcion para borrar un producto */
  $("body").on("click", ".delete_model", delete_model);
  function delete_model(e) {
    e.preventDefault();

    let button = $(this),
      id = button.data("id"),
      action = "delete_model";

    if (!confirm("¿Estás seguro?")) return false;

    // Petición
    $.ajax({
      url: "ajax.php",
      type: "post",
      dataType: "json",
      data: { action, id },
      beforeSend: () => {
        $("body").waitMe();
      },
    })
      .done((res) => {
        if (res.status === 200) {
          notify(res.msg);
          get_quote();
        } else {
          notify(res.msg, "danger");
        }
      })
      .fail((err) => {
        notify("Hubo un problema con la petición.", "danger");
      })
      .always(() => {
        $("body").waitMe("hide");
      });
  }

  //* Funcion para editar producto
  $("body").on("click", ".edit_model", edit_model);
  function edit_model(e) {
    e.preventDefault();

    let button = $(this),
      id = button.data("id"),
      action = "edit_model",
      wrapper_update_model = $(".wrapper_update_model"),
      form_update_model = $("#save_model");

    // Petición
    $.ajax({
      url: "ajax.php",
      type: "post",
      dataType: "json",
      data: { action, id },
      beforeSend: () => {
        $("body").waitMe();
      },
    })
      .done((res) => {
        if (res.status === 200) {
          $("#id_model", form_update_model).val(res.data.id);
          $("#cod_barras", form_update_model).val(res.data.cod_barras);
          $("#modelo", form_update_model).val(res.data.modelo);
          $("#descripcion", form_update_model).val(res.data.descripcion);
          $("#cantidad", form_update_model).val(res.data.cantidad);
          $("#imagen", form_update_model).val(res.data.imagen);
          $("#precio_unitario", form_update_model).val(
            res.data.precio_unitario
          );
          wrapper_update_model.fadeIn();
          notify(res.msg);
        } else {
          notify(res.msg, "danger");
        }
      })
      .fail((err) => {
        notify("Hubo un problema con la petición.", "danger");
      })
      .always(() => {
        $("body").waitMe("hide");
      });
  }

  // Función guardar cambios de concepto editado
  $("#save_model").on("submit", save_model);
  function save_model(e) {
    e.preventDefault();

    let form = $("#save_model"),
      action = "save_model",
      data = new FormData(form.get(0)),
      wrapper_update_model = $(".wrapper_update_model"),
      errors = 0;

    // Agregar la acción al objeto data
    data.append("action", action);

    // Validar el concepto
    let modelo = $("#modelo", form).val(),
      precio_unitario = parseFloat($("#precio_unitario", form).val());

    if (modelo.length < 2) {
      notify(
        "Ingresa un concepto válido por favor.  (MAYOR DE 2 CARACTERES)",
        "danger"
      );
      errors++;
    }

    // Validar el precio
    if (precio_unitario < 1) {
      notify("Por favor ingresa un precio mayor a $1.00", "danger");
      errors++;
    }

    if (errors > 0) {
      notify("Completa el formulario.", "danger");
      return false;
    }

    $.ajax({
      url: "ajax.php",
      type: "POST",
      dataType: "json",
      cache: false,
      processData: false,
      contentType: false,
      data: data,
      beforeSend: () => {
        form.waitMe();
      },
    })
      .done((res) => {
        if (res.status === 200) {
          wrapper_update_model.fadeOut();
          form.trigger("reset");
          notify(res.msg);
          get_quote();
        } else {
          notify(res.msg, "danger");
        }
      })
      .fail((err) => {
        notify("Hubo un problema con la petición, intenta de nuevo.", "danger");
        wrapper_update_model.fadeOut();
        form.trigger("reset");
      })
      .always(() => {
        form.waitMe("hide");
      });
  }

  // Función para generar la cotización
  $("#generate_quote").on("click", generate_quote);
  function generate_quote(e) {
    e.preventDefault();

    let button = $(this),
      default_text = button.html(), // "Generar"
      new_text = "Volver a generar",
      download = $("#download_quote"),
      send = $("#send_quote"),
      cliente = $("#cliente").val(),
      empresa = $("#empresa").val(),
      email = $("#email").val(),
      telefono = $("#telefono").val(),
      tiempo_entrega = $("#tiempo_entrega").val(),
      forma_pago = $("#forma_pago").val(),
      action = "generate_quote",
      errors = 0;

    // Validando la acción
    if (!confirm("¿Estás seguro?")) return false;

    // Validando la información
    if (cliente.length < 5) {
      notify(
        "Ingresa un nombre para el cliente por favor (MAS DE 5 CARACTERES)",
        "danger"
      );
      errors++;
    }

    if (empresa.length < 5) {
      notify(
        "Ingresa una empresa válida por favor (MAS DE 5 CARACTERES)",
        "danger"
      );
      errors++;
    }

    if (email.length < 5) {
      notify(
        "Ingresa una dirección de correo válida por favor (MAS DE 5 CARACTERES)",
        "danger"
      );
      errors++;
    }

    if (errors > 0) {
      return false;
    }

    // Petición
    $.ajax({
      url: "ajax.php",
      type: "POST",
      dataType: "json",
      cache: false,
      data: {
        action,
        cliente,
        empresa,
        email,
        telefono,
        tiempo_entrega,
        forma_pago,
      },
      beforeSend: () => {
        $("body").waitMe();
        button.html("Generando...");
      },
    })
      .done((res) => {
        if (res.status === 200) {
          notify(res.msg);
          download.attr("href", res.data.url);
          download.fadeIn();
          send.attr("data-number", res.data.number);
          send.fadeIn();
          button.html(new_text);
        } else {
          notify(res.msg, "danger");
          download.attr("href", "");
          download.fadeOut();
          send.attr("data-number", "");
          send.fadeOut();
          button.html("Reintentar");
        }
      })
      .fail((err) => {
        notify("Hubo un problema con la petición, intenta de nuevo.", "danger");
        button.html(default_text);
      })
      .always(() => {
        $("body").waitMe("hide");
      });
  }

  //! Hide edit box
  $("#cancel_edit").on("click", (e) => {
    e.preventDefault();

    let button = $(this),
      wrapper = $(".wrapper_update_model"),
      form = $("#save_model");

    wrapper.fadeOut();
    form.trigger("reset");
  });
});
