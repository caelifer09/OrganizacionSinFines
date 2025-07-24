    function filtrarEventos() {
      const filtro = document.getElementById('events').value.toLowerCase();
      const eventos = document.querySelectorAll('#results-container .list-group-item');

      eventos.forEach(evento => {
        const contenido = evento.textContent.toLowerCase();
        evento.style.display = contenido.includes(filtro) ? '' : 'none';
      });
    }
    function notificar(mensaje, tipo = 'info') {
      const container = document.getElementById('notifications');
      const div = document.createElement('div');
      div.className = `alert alert-${tipo} notification`;
      div.textContent = mensaje;
      container.appendChild(div);

      setTimeout(() => {
        div.remove();
      }, 5000);
    }
    setInterval(() => {
      const mensajes = [
        { msg: "¡Gracias a Ana por su donación de $50!", tipo: "success" },
        { msg: "¡Nueva campaña activa: 'Alimentos para Todos'!", tipo: "primary" },
        { msg: "¡Hemos alcanzado el 60% de la meta mensual!", tipo: "info" },
        { msg: "Gracias por tu donacion Claudio.", tipo: "success" }
      ];
      const aleatorio = mensajes[Math.floor(Math.random() * mensajes.length)];
      notificar(aleatorio.msg, aleatorio.tipo);
    }, 10000);
    document.addEventListener('DOMContentLoaded', () => {
      const donationsTab = document.querySelector('#donations-tab');
      let loaded = false;
      document.querySelector('a[href="#donations-tab"]').addEventListener('click', () => {
        if (!loaded) {
          fetch('cargar_donaciones.php')
            .then(response => response.text())
            .then(html => {
              document.getElementById('donations').innerHTML = html;
              loaded = true;
            });
        }
      });
    });
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-donar").forEach(function (btn) {
      btn.addEventListener("click", function () {
        const id = this.dataset.id;
        const nombre = this.dataset.nombre;
        fetch("agregar_a_sesion.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `id=${encodeURIComponent(id)}&nombre=${encodeURIComponent(nombre)}`
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === "added") {
            alert("Proyecto agregado al carrito de donación.");
          } else if (data.status === "exists") {
            alert("Este proyecto ya está en el carrito.");
          } else {
            alert("Ocurrió un error al agregar el proyecto.");
          }
        })
        .catch(err => {
          console.error("Error en la petición:", err);
        });
      });
    });
  });

  setInterval(() => {
    fetch('agregar_a_sesion.php', { method: 'POST', body: new URLSearchParams({ id: 0, nombre: 'keep' }) });
  }, 5 * 60 * 1000);

  setTimeout(() => {
    if (confirm("Tu sesión está por expirar. ¿Deseas continuar?")) {
      fetch('agregar_a_sesion.php', { method: 'POST', body: new URLSearchParams({ id: 0, nombre: 'keep' }) });
    }
  }, 25 * 60 * 1000);
