if (!console) {
  console = {};
  console.log = function () {};
}

if (typeof String.prototype.trim != "function") {
  String.prototype.trim = function (str) {
    return $.trim(str);
  };
}

if (typeof String.prototype.startsWith != "function") {
  String.prototype.startsWith = function (str) {
    return this.slice(0, str.length) == str;
  };
}

if (typeof String.prototype.endsWith != "function") {
  String.prototype.endsWith = function (str) {
    return this.slice(-str.length) == str;
  };
}

if (typeof String.prototype.contains != "function") {
  String.prototype.contains = function (str) {
    return this.indexOf(str) != -1;
  };
}

if (typeof String.prototype.replaceAll != "function") {
  String.prototype.replaceAll = function (find, replace) {
    var str = this;
    return str.replace(
      new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&"), "g"),
      replace
    );
  };
}

if (typeof base_url == "undefined") {
  var getUrl = window.location;
  var base_url =
    getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
  if (!base_url.endsWith("/")) {
    base_url = base_url + "/";
  }
}

function fixUrl(purl) {
  if (
    purl.startsWith("http://") ||
    purl.startsWith("https://") ||
    typeof base_url == "undefined"
  ) {
    return purl;
  } else {
    return base_url + "index.php/" + purl;
  }
}

var ResultData = {};
let controlBusqueda = {};

function getValue(purl, pparameters, callbackfunction) {
  var valor = "N/A_";
  if (callbackfunction) {
    asinc = true;
  } else {
    asinc = false;
  }

  let to = 1200000;
  if (
    typeof pparameters !== "undefined" &&
    typeof pparameters.timeout !== "undefined"
  ) {
    to = pparameters.timeout;
  }

  $.ajax({
    url: fixUrl(purl),
    type: "POST",
    data: pparameters,
    async: asinc,
    cache: false,
    dataType: "text",
    timeout: to,
    error: function (a, b) {
      valor = b;
    },
    success: function (msg) {
      valor = msg;
      if (callbackfunction) {
        callbackfunction(valor);
      }
    },
  });
  return valor;
}

function getObject(purl, pparameters, callbackfunction) {
  if (callbackfunction) {
    getValue(purl, pparameters, function (s) {
      var obj = new Function("return " + s)();
      callbackfunction(obj);
    });
  } else {
    var t = getValue(purl, pparameters);
    return new Function("return " + t)();
  }
}

function redirectTo(purl) {
  setTimeout(function () {
    window.location.href = fixUrl(purl);
  }, 0);
}

function openInNew(purl) {
  window.open(fixUrl(purl), "_new");
}

function redirectByPost(purl, pparameters, in_new_tab) {
  var url = fixUrl(purl);
  pparameters = typeof pparameters == "undefined" ? {} : pparameters;
  in_new_tab = typeof in_new_tab == "undefined" ? true : in_new_tab;
  var form = document.createElement("form");
  $(form)
    .attr("id", "reg-form")
    .attr("name", "reg-form")
    .attr("action", url)
    .attr("method", "post")
    .attr("enctype", "multipart/form-data");
  if (in_new_tab) {
    $(form).attr("target", "_blank");
  }
  $.each(pparameters, function (key) {
    $(form).append(
      '<input type="text" name="' + key + '" value="' + this + '" />'
    );
  });
  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
  return false;
}

function trim(inputString) {
  return $.trim(inputString);
}

function refreshPage() {
  location.reload();
}

function getHourNumber() {
  return new Date().getTime();
}

var timestamp = getHourNumber();

function moveElement(elem, to) {
  elem.appendTo(to);
}

$.fn.serializeObject = function () {
  var o = {};
  var a = this.serializeArray();
  $.each(a, function () {
    if (o[this.name]) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || "");
    } else {
      o[this.name] = this.value || "";
    }
  });
  return o;
};

$.fn.shake = function (options) {
  var settings = {
    shakes: 2,
    distance: 10,
    duration: 400,
  };
  if (options) {
    $.extend(settings, options);
  }
  var pos;
  return this.each(function () {
    var $this = $(this);
    pos = $this.css("position");
    if (!pos || pos === "static") {
      $this.css("position", "relative");
    }
    for (var x = 1; x <= settings.shakes; x++) {
      $this
        .animate(
          {
            left: settings.distance * -1,
          },
          settings.duration / settings.shakes / 4
        )
        .animate(
          {
            left: settings.distance,
          },
          settings.duration / settings.shakes / 2
        )
        .animate(
          {
            left: 0,
          },
          settings.duration / settings.shakes / 4
        );
    }
  });
};

$(document)
  .ajaxStart(function () {
    $.blockUI({
      message: '<h1><i class="fa fa-spinner fa-spin"></i></h1>',
      baseZ: 80000,
    });
  })
  .ajaxStop(function () {
    $.unblockUI();
  });

function ponTotalesEnTabla(t, enRenglonFinal = false, enColumnaFinal = true) {
  if (t.find("tr:eq(0) td:last").text() !== "Total") {
    if (enRenglonFinal && t.find("tbody tr").length > 1) {
      var renglones = t.find("tbody tr").length;
      var cols = t.find("tbody tr:last-child td").length;
      t.find("tbody").append("<tr></tr>");
      lr = t.find("tbody tr:last-child");
      for (i = 1; i <= cols; i++) {
        lr.append('<td style="font-weight:bold" class="totalt">Total</td>');
      }
      for (i = 1; i <= cols - 1; i++) {
        tt = 0;
        for (j = 0; j <= renglones - 1; j++) {
          tt += parseInt(t.find("tbody tr").eq(j).find("td").eq(i).text());
        }
        if (Number.isNaN(tt)) {
          tt = "";
        }
        lr.find("td").eq(i).text(tt);
      }
    }
    if (enColumnaFinal && t.find("tbody tr:last-child td").length > 2) {
      t.find("tr").append('<td style="font-weight:bold">Total</td>');
      for (j = 0; j <= t.find("tbody tr").length - 1; j++) {
        tt = 0;
        rr = t.find("tbody tr").eq(j);
        for (i = 1; i <= t.find("tbody tr:last-child td").length - 1; i++) {
          tt += parseInt(rr.find("td").eq(i).text());
        }
        if (Number.isNaN(tt)) {
          tt = "";
        }
        rr.find("td").eq(t.find("tbody tr:last-child td").length).text(tt);
      }
    }
  }
}

function exportToExcel(fileName, htmls) {
  var uri = "data:application/vnd.ms-excel;charset=UTF-8;base64,";
  var template =
    '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta charset="utf-8" />  <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
  var base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)));
  };

  var format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
      return c[p];
    });
  };

  var ctx = {
    worksheet: "Worksheet",
    table: htmls,
  };

  var link = document.createElement("a");
  document.body.appendChild(link);
  link.download = fileName + ".xls";
  link.href = uri + base64(format(template, ctx));
  link.click();
  link.remove();
}

function ponTablaPaginada(tableSelector) {
  // Opciones de configuración de DataTables
  var options = {
    aaSorting: [],
    sPaginationType: "full_numbers",
    bJQueryUI: false,
    bLengthChange: true,
    bDeferRender: true,
    oLanguage: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron registros",
      sInfo: "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
      sInfoEmpty: "Mostrando desde 0 hasta 0 de 0 registros",
      sInfoFiltered: "",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      oPaginate: {
        sFirst: "Primero",
        sPrevious: "Anterior",
        sNext: "Siguiente",
        sLast: "Último",
      },
    },
    sDom: 'T<"clear">frtip',
  };

  // Aplicar configuración de DataTables a la tabla
  $(tableSelector).dataTable(options);

  // Aplicar estilo a los botones de paginación
  //aplicarEstiloPaginacion(tableSelector);
}

/**
 * Aplica estilo de botones de paginación
 * @param {string} tableSelector - Selector de la tabla
 */
function aplicarEstiloPaginacion(tableSelector) {
  $(tableSelector)
    .parent()
    .find(".paginate_button, .paginate_active")
    .addClass("btn btn-xs btn-info");
  /* .removeClass("disabled")
    .filter(".paginate_button_disabled, .paginate_active")
    .addClass("disabled");*/
}

function muestraError(tipo = "error", titulo, mensaje, footer = "") {
  Swal.fire({
    icon: tipo,
    title: titulo,
    text: mensaje,
    footer: footer,
  });
}

function muestraMensajeAlerta(tipo = "error", mensaje = "", timer = 4500) {
  Toast.fire({
    icon: tipo,
    title: mensaje,
    timer: timer,
  });
}
function muestraMensajeAlertaAbajo(tipo = "error", mensaje = "", timer = 4500) {
  ToastBottom.fire({
    icon: tipo,
    title: mensaje,
    timer: timer,
  });
}

function showModal(html, encabezado = "", id = "miModal", onClose = null) {
  if (!$("#" + id).length) {
    $("body").append(
      `<div id="${id}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="false" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title" id="${id}-modaltitle">Título de la modal</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div id="${id}-modalescondido"> </div> 
          </div>
          <div class="modal-footer"></div>
          </div>
          </div>
          </div>`
    );
  }

  if (onClose) {
    $("#" + id).on("hidden.bs.modal", function () {
      onClose();
      $("#" + id).unbind();
    });
  }

  $("#" + id + "-modalescondido").html(html);
  $("#" + id + "-modaltitle").text(encabezado);
  $("#" + id).modal("show");
}

function convertToTable(obj) {
  if (Array.isArray(obj)) {
    return arrayToTable(obj);
  } else {
    return objectToTable(obj);
  }
}

function objectToTable(obj) {
  var table = "<table class='table'>";
  var keys = Object.keys(obj);
  table += createHeaderRow(keys);
  table += objectToRow(obj, keys);
  table += "</table>";
  return table;
}

function arrayToTable(array) {
  var table = "<table class='table'>";
  var keys = Object.keys(array[0]);
  table += "<thead>";
  table += createHeaderRow(keys);
  table += "</thead>";
  table += "<tbody>";
  array.forEach(function (item) {
    table += objectToRow(item, keys);
  });
  table += "</tbody>";
  table += "</table>";
  return table;
}

function objectToRow(obj, keys) {
  var row = "<tr>";
  if (!keys) {
    keys = Object.keys(obj);
  }
  keys.forEach(function (key) {
    row += "<td>" + obj[key] + "</td>";
  });
  row += "</tr>";
  return row;
}

function createHeaderRow(keys) {
  var row = "<tr>";
  keys.forEach(function (key) {
    row += "<th>" + key + "</th>";
  });
  row += "</tr>";
  return row;
}

function limitText(limitField, limitNum) {
  if (limitField.value.length > limitNum) {
    limitField.value = limitField.value.substring(0, limitNum);
  }
}

function ponValorEnSelect(elemento, id, texto) {
  elemento.find("option[value='" + id + "']").remove();
  elemento.find("option").prop("selected", false).removeAttr("selected");
  var newOption = $("<option></option>")
    .val(id)
    .text(texto)
    .attr("selected", "selected");
  elemento.append(newOption).val(id).trigger("change");
}

function ponerIconoLupaEnControl(elemento) {
  elemento.wrap(`<div class="input-group"></div>`);
  let icono = $(`<div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-search"></i>
                    </span>
                 </div>`);
  icono.insertBefore(elemento);
}

function limpia(cadena) {
  return cadena.replace("-", " ").replace(/\s+/g, " ").trim();
}

function ponBusquedaEn(elemento, ruta, params, callBack) {
  ponerIconoLupaEnControl(elemento);
  elemento.keyup(function (e) {
    if (e.keyCode != 13) return;
    if ($(this).val().length > 2) {
      valorabuscar = limpia($(this).val());
      controlBusqueda = $(this);
      getValue(
        "utilerias/busqueda",
        {
          valorabuscar: valorabuscar,
          ruta: ruta,
          params: params,
        },
        function (data) {
          ResultData = {};
          showModal(data, "", "busquedaModal", function () {
            callBack(controlBusqueda);
          });
        }
      );
    }
  });
}

function inArray(element, array) {
  return array.includes(element);
}

async function getValue2(purl, pparameters) {
  try {
    let valor = "N/A_";
    let asinc = true;
    let to = 1200000;

    if (pparameters && pparameters.timeout !== undefined) {
      to = pparameters.timeout;
    }

    const response = await fetch(fixUrl(purl), {
      method: "POST",
      body: JSON.stringify(pparameters),
      headers: {
        "Content-Type": "application/json",
      },
      mode: "cors", // Puedes ajustar esto según tus necesidades
      cache: "no-cache",
      credentials: "same-origin",
      redirect: "follow",
      referrerPolicy: "no-referrer",
      timeout: to,
    });

    if (!response.ok) {
      throw new Error(`Request failed with status: ${response.status}`);
    }

    valor = await response.text();
    return valor;
  } catch (error) {
    throw error;
  }
}

async function getObject2(purl, pparameters) {
  try {
    const value = await getValue2(purl, pparameters);
    return JSON.parse(value);
  } catch (error) {
    throw error;
  }
}

function getSession() {
  return getObject("admin/sess", {});
}

/*
Uso Sincrono: 

            (async () => {
                try {
                    p = await getObject2('admin/test', {});
                    console.log('en la funcion, p es ', p);
                    $('h1.test').text(p.usuario);
                } catch (error) {

                }
            })();

Uso Asincrono: getObject2('admin/test',{}).then((p)=>{console.log(p);});
*/

function mostrarCargando() {
  let divLoading = document.querySelector(".loading-container");
  if (!divLoading) {
    let loadingContainer = document.createElement("div");
    loadingContainer.classList.add("loading-container");
    // Crear el elemento de la animación de carga
    let loading = document.createElement("div");
    loading.classList.add("loading");
    loadingContainer.appendChild(loading);

    // Establecer estilos para el contenedor y la animación
    loadingContainer.style.position = "fixed";
    loadingContainer.style.top = "0";
    loadingContainer.style.left = "0";
    loadingContainer.style.width = "100%";
    loadingContainer.style.height = "100%";
    loadingContainer.style.backgroundColor = "rgba(255, 255, 255, 0.8)";
    loadingContainer.style.display = "flex";
    loadingContainer.style.alignItems = "center";
    loadingContainer.style.justifyContent = "center";
    loadingContainer.style.zIndex = "9999";

    loading.style.border = "5px solid #f3f3f3";
    loading.style.borderTop = "5px solid #3498db";
    loading.style.borderRadius = "50%";
    loading.style.width = "50px";
    loading.style.height = "50px";
    loading.style.animation = "spin 2s linear infinite";
    document.body.appendChild(loadingContainer);
  }
}

function ocultarCargando() {
  let loadingContainer = document.querySelector(".loading-container");
  if (loadingContainer) {
    loadingContainer.remove();
  }
}
