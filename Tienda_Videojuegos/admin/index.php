<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Videojuegos</title>
    <style>
        /* Estilos básicos */
        body { font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; }
        h1 { color: #333; }
        form { margin-bottom: 20px; }
        input, textarea, button { margin: 5px; padding: 10px; }
        table { width: 80%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        .actions a { margin: 0 5px; color: blue; text-decoration: none; cursor: pointer; }
        
        /* Estilos del modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; }
        .modal-content { background: #fff; padding: 20px; border-radius: 5px; width: 300px; }
        .close { cursor: pointer; color: red; float: right; }
    </style>
</head>
<body>
    <h1>Gestión de Videojuegos</h1>

    <!-- Formulario para agregar un videojuego -->
    <form id="addGameForm">
        <input type="text" id="titulo" placeholder="Título del videojuego" required>
        <input type="number" id="precio" placeholder="Precio" required>
        <textarea id="descripcion" placeholder="Descripción"></textarea>
        <input type="number" id="cantidad" placeholder="Cantidad" required>
        <button type="button" onclick="agregarVideojuego()">Agregar Videojuego</button>
    </form>

    <!-- Tabla de videojuegos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="videojuegosTable">
        </tbody>
    </table>

    <!-- Modal de edición -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h3>Editar Videojuego</h3>
            <input type="hidden" id="editId">
            <input type="text" id="editTitulo" placeholder="Título" required>
            <input type="number" id="editPrecio" placeholder="Precio" required>
            <textarea id="editDescripcion" placeholder="Descripción"></textarea>
            <input type="number" id="editCantidad" placeholder="Cantidad" required>
            <button type="button" onclick="actualizarVideojuego()">Actualizar</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', listarVideojuegos);

        function listarVideojuegos() {
            fetch('crud.php?action=listar')
                .then(response => response.json())
                .then(data => {
                    const videojuegosTable = document.getElementById("videojuegosTable");
                    videojuegosTable.innerHTML = "";

                    data.forEach(videojuego => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${videojuego.id}</td>
                            <td>${videojuego.titulo}</td>
                            <td>${videojuego.precio}</td>
                            <td>${videojuego.descripcion}</td>
                            <td>${videojuego.cantidad}</td>
                            <td class="actions">
                                <a onclick="mostrarModal(${videojuego.id}, '${videojuego.titulo}', ${videojuego.precio}, '${videojuego.descripcion}', ${videojuego.cantidad})">Editar</a>
                                <a onclick="eliminarVideojuego(${videojuego.id})">Eliminar</a>
                            </td>
                        `;
                        videojuegosTable.appendChild(row);
                    });
                });
        }

        function agregarVideojuego() {
            const titulo = document.getElementById("titulo").value;
            const precio = document.getElementById("precio").value;
            const descripcion = document.getElementById("descripcion").value;
            const cantidad = document.getElementById("cantidad").value;

            fetch('crud.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=agregar&titulo=${titulo}&precio=${precio}&descripcion=${descripcion}&cantidad=${cantidad}`
            }).then(() => listarVideojuegos());
        }

        function mostrarModal(id, titulo, precio, descripcion, cantidad) {
            document.getElementById('editId').value = id;
            document.getElementById('editTitulo').value = titulo;
            document.getElementById('editPrecio').value = precio;
            document.getElementById('editDescripcion').value = descripcion;
            document.getElementById('editCantidad').value = cantidad;
            document.getElementById('editModal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function actualizarVideojuego() {
            const id = document.getElementById("editId").value;
            const titulo = document.getElementById("editTitulo").value;
            const precio = document.getElementById("editPrecio").value;
            const descripcion = document.getElementById("editDescripcion").value;
            const cantidad = document.getElementById("editCantidad").value;

            fetch('crud.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=actualizar&id=${id}&titulo=${titulo}&precio=${precio}&descripcion=${descripcion}&cantidad=${cantidad}`
            }).then(() => {
                cerrarModal();
                listarVideojuegos();
            });
        }

        function eliminarVideojuego(id) {
            fetch('crud.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=eliminar&id=${id}`
            }).then(() => listarVideojuegos());
        }
    </script>
</body>
</html>
