<style>
  /* Gradiente + animación del botón */
  .btn-gradient {
    background: linear-gradient(135deg, #034d81, #38948f);
    background-size: 400% 400%;
    animation: gradientBG 8s ease infinite;
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease-in-out, box-shadow 0.3s ease;
  }

  .btn-gradient:hover {
    transform: rotate(90deg) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
  }

  @keyframes gradientBG {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }

  /* Tooltip animado */
  .tooltip {
    opacity: 0 !important;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
  }

  .tooltip.show {
    opacity: 1 !important;
    transform: translateY(0);
  }
</style>

<div class="modal fade" id="modalCambioManual" tabindex="-1" role="dialog" aria-labelledby="modalCambioManualLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header bg-gradient text-white d-flex align-items-center justify-content-between">
        <h5 class="modal-title mayus" id="modalCambioManualLabel">Registrar cambios</h5>
        <!-- Icono de instrucciones con popover -->
        <button type="button" class="btn btn-outline-light btn-sm ms-2"
          data-bs-toggle="popover" data-bs-html="true" data-bs-placement="bottom"
          data-bs-content='
                <ul class="mb-0">
                  <li>No se permiten cambios de <strong>estado</strong> ni <strong>préstamos/asignaciones</strong>.</li>
                  <li>Acciones de <strong>Hardware</strong> y <strong>Software</strong> solo si <strong>no modifican directamente la tabla equipos</strong>.</li>
                  <li>Ejemplos de Software: instalación de programas, activación de licencias, actualizaciones que no cambian el sistema operativo.</li>
                  <li>Ejemplos de Hardware: mantenimiento, limpieza, reparación física, reemplazo de componentes externos como toner.</li>
                  <li>En Notas, describe detalladamente lo realizado. Ejemplo: "Se instaló Office 365; licencia activada correctamente".</li>
                </ul>'>
          <i class="fa-solid fa-circle-question"></i>
        </button>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="formCambioManual">
          <div class="form-group">
            <label for="equipo_id" class="label-span">Equipo:</label>
            <select class="form-control" id="equipo_id" name="equipo_id" required style="width: 100%;"
              title="Selecciona el equipo al que se aplicará el cambio.">
              <option value="">Selecciona un equipo...</option>
            </select>
          </div>

          <div class="form-group">
            <label for="tipo_evento" class="label-span">Tipo de evento:
              <span data-bs-toggle="tooltip" title="Selecciona la categoría del cambio. Solo se permiten acciones que no modifiquen directamente el equipo como estado o préstamos.">
                <i class="bi bi-info-circle"></i>
              </span>
            </label>
            <select class="form-control" id="tipo_evento" name="tipo_evento" required>
              <option value="">Selecciona un tipo de evento...</option>
              <option value="Mantenimiento">Mantenimiento</option>
              <option value="Reporte">Reporte</option>
              <option value="Software">Software</option>
              <option value="Hardware">Hardware</option>
              <option value="Otros">Otros</option>
            </select>
          </div>

          <div class="form-group">
            <label for="notas" class="label-span">Notas(Detalles):
              <span data-bs-toggle="tooltip" title="Describe detalladamente el cambio realizado. Ejemplo: 'Instalación de Office 365 y activación de licencia'.">
                <i class="bi bi-info-circle"></i>
              </span>
            </label>
            <textarea class="form-control" id="notas" name="notas" rows="3" placeholder="Descripción detallada..." required></textarea>
          </div>

          <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['user_id']; ?>">
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-cancel-form mayus" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formCambioManual" class="btn btn-agg-form mayus">Guardar Cambio</button>
      </div>

    </div>
  </div>
</div>

<script>
  // Inicializar popovers
  document.addEventListener("DOMContentLoaded", function() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    const popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl)
    })
  });
</script>



<!-- jQuery -->
<script src="../vendor/JQuery/jquery-3.7.1.min.js"></script>

<!-- Select2 -->
<link rel="stylesheet" href="../vendor/Select2/select2.min.css">
<script src="../vendor/Select2/select2.min.js"></script>

<script>
  $(document).ready(function() {
    // console.log("DOM listo");

    // Inicializar tooltip
    $('[data-toggle="tooltip"]').tooltip();
    // console.log("Tooltip inicializado");

    // Abrir modal
    $('#btnRegistrarCambio').click(function() {
      // console.log("Botón de registro clickeado");
    });

    // Inicializar Select2 en el modal
    $('#modalCambioManual').on('shown.bs.modal', function() {
      // console.log("Modal abierto");

      if (!$('#equipo_id').hasClass("select2-hidden-accessible")) {
        // console.log("Inicializando Select2");

        $('#equipo_id').select2({
          placeholder: "Selecciona un equipo...",
          allowClear: true,
          ajax: {
            url: '../includes/_equipos/get_equipos.php',
            dataType: 'json',
            delay: 250,
            data: function(params) {
              // console.log("Buscando:", params.term);
              return {
                q: params.term
              };
            },
            processResults: function(data) {
              // console.log("Resultados:", data);
              return {
                results: data
              };
            },
            error: function(xhr, status, error) {
              console.error("Error AJAX Select2:", status, error);
              alert("Ocurrió un error al buscar equipos");
            },
            cache: true
          },
          minimumInputLength: 1,
          dropdownParent: $('#modalCambioManual')
        });
      }
    });
  });
</script>


<script>
  $(document).ready(function() {

    $('#formCambioManual').submit(function(e) {
      e.preventDefault(); // Evita que recargue la página
      let formData = $(this).serialize();

      $.ajax({
        url: '../includes/_equipos/save_cambioManual.php', // archivo PHP que guarda los datos
        type: 'POST',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
          // Opcional: deshabilitar botones para evitar doble submit
          $('#formCambioManual button[type="submit"]').prop('disabled', true);
        },
        success: function(response) {
          $('#formCambioManual button[type="submit"]').prop('disabled', false);

          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: response.mensaje,
              confirmButtonText: 'Aceptar',
              confirmButtonColor: '#034D81'
            }).then(() => {
              $('#modalCambioManual').modal('hide');
              $('#formCambioManual')[0].reset();
              $('#equipo_id').val(null).trigger('change'); // limpiar Select2

              // 🔹 Recargar la página después de guardar
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.mensaje || 'Ocurrió un error al guardar'
            });
          }
        },
        error: function(xhr, status, error) {
          $('#formCambioManual button[type="submit"]').prop('disabled', false);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error en la comunicación con el servidor: ' + error
          });
        }
      });
    });

  });
</script>