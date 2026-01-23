<?php
$pageTitle = "Editar Usuario";
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/config.php';

/* =====================================================
  1️⃣ OBTENER ID
  ===================================================== */
$id_persona = $_GET['id'] ?? null;

$fromPerfil = isset($_GET['from']) && $_GET['from'] === 'perfil';

if ($fromPerfil && $_SESSION['id_persona'] != $id_persona) {
    header("Location: /pages/dashboard.php");
    exit;
}



if (!$id_persona) {
    header("Location: listado.php");
    exit;
}

/* =====================================================
  1️⃣.1 ELIMINAR TELÉFONO (MISMO ARCHIVO)
  ===================================================== */
if (isset($_GET['del_tel'])) {
    $stmt = $pdo->prepare("CALL sp_eliminar_persona_telefono(?)");
    $stmt->execute([(int) $_GET['del_tel']]);
    $stmt->closeCursor();

    header("Location: editar.php?id=" . $id_persona);
    exit;
}

/* =====================================================
  1️⃣.2 ELIMINAR CORREO (MISMO ARCHIVO)
  ===================================================== */
if (isset($_GET['del_correo'])) {
    $stmt = $pdo->prepare("CALL sp_eliminar_persona_correo(?)");
    $stmt->execute([(int) $_GET['del_correo']]);
    $stmt->closeCursor();

    header("Location: editar.php?id=" . $id_persona);
    exit;
}

/* =====================================================
  2️⃣ CARGAR USUARIO (SP)
  ===================================================== */
$stmt = $pdo->prepare("CALL sp_obtener_persona(?)");
$stmt->execute([$id_persona]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

if (!$usuario) {
    header("Location: listado.php");
    exit;
}

/* =====================================================
  2️⃣.1 CARGAR CORREOS (SP)
  ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_correos_persona(?)");
$stmt->execute([$id_persona]);
$correos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* =====================================================
  2️⃣.2 CARGAR TELÉFONOS (SP)
  ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_telefonos_persona(?)");
$stmt->execute([$id_persona]);
$telefonos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* =====================================================
  2️⃣.3 CARGAR TIPOS DE TELÉFONO (SP)
  ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_tipos_telefono()");
$stmt->execute();
$tiposTelefono = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* HTML reutilizable */
$opcionesTelefonoHTML = '';
foreach ($tiposTelefono as $tt) {
    $opcionesTelefonoHTML .= '<option value="' . $tt['id'] . '">'
            . htmlspecialchars($tt['nombre']) .
            '</option>';
}


/* =====================================================
  2️⃣.4 CARGAR ROLES (SP)
  ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_roles()");
$stmt->execute();
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* =====================================================
  2️⃣.5 ROL ACTUAL DEL USUARIO (SP)
  ===================================================== */
$stmt = $pdo->prepare("CALL sp_obtener_roles_persona(?)");
$stmt->execute([$id_persona]);
$rolActual = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

$rolActualId = $rolActual['id'] ?? null;

/* =====================================================
  3️⃣ GUARDAR CAMBIOS
  ===================================================== */
$passwordError = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* 🔹 Datos generales */
    $stmt = $pdo->prepare("CALL sp_editar_persona(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $id_persona,
        $_POST['nombre'],
        $_POST['apellido1'],
        $_POST['apellido2'],
        0,
        $_POST['cedula'],
        '1990-01-01',
        ''
    ]);
    $stmt->closeCursor();

    /* 🔹 Estado */
    $stmt = $pdo->prepare("CALL sp_actualizar_estado_persona(?, ?)");
    $stmt->execute([$id_persona, $_POST['estado']]);
    $stmt->closeCursor();

    /* 🔹 Contraseña */
    if (!empty($_POST['password']) && $_POST['password'] === $_POST['password_confirm']) {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("CALL sp_actualizar_contrasena(?, ?)");
        $stmt->execute([$id_persona, $hash]);
        $stmt->closeCursor();
    }

    /* 🔹 Correos nuevos */
    if (!empty($_POST['nuevo_correo'])) {
        foreach ($_POST['nuevo_correo'] as $i => $correo) {
            $stmt = $pdo->prepare("CALL sp_agregar_persona_correo(?, ?, ?)");
            $stmt->execute([$id_persona, $correo, $_POST['correo_desc'][$i]]);
            $stmt->closeCursor();
        }
    }

    /* 🔹 Teléfonos nuevos */
    if (!empty($_POST['nuevo_telefono'])) {
        foreach ($_POST['nuevo_telefono'] as $i => $telefono) {
            $stmt = $pdo->prepare("CALL sp_agregar_persona_telefono(?, ?, ?)");
            $stmt->execute([
                $id_persona,
                $_POST['telefono_tipo'][$i],
                $telefono
            ]);
            $stmt->closeCursor();
        }
    }

    /* 🔹 Teléfonos existentes (hover-edit) */
    if (!empty($_POST['telefono_existente'])) {
        foreach ($_POST['telefono_existente'] as $id_tel => $valor) {
            $stmt = $pdo->prepare("CALL sp_editar_persona_telefono(?, ?, ?)");
            $stmt->execute([
                $id_tel,
                $_POST['telefono_tipo_existente'][$id_tel],
                $valor
            ]);
            $stmt->closeCursor();
        }
    }
    /* =====================================================
      🔹 ACTUALIZAR ROL (SOLO ADMIN / NO PERFIL)
      ===================================================== */
    if (
            isset($fromPerfil) &&
            $fromPerfil === false &&
            isset($_POST['rol_id']) &&
            $_POST['rol_id'] !== ''
    ) {
        $rolId = (int) $_POST['rol_id'];

        $stmt = $pdo->prepare("CALL sp_actualizar_rol_persona(?, ?)");
        $stmt->execute([
            $id_persona,
            $rolId
        ]);
        $stmt->closeCursor();
    }

    /* =====================================================
      🔐 CAMBIO DE CONTRASEÑA (OPCIONAL)
      ===================================================== */
    $pwdActual = $_POST['password_actual'] ?? '';
    $pwdNueva = $_POST['password_nueva'] ?? '';
    $pwdConf = $_POST['password_confirmar'] ?? '';

    if ($pwdActual || $pwdNueva || $pwdConf) {

        if (!$pwdActual || !$pwdNueva || !$pwdConf) {
            $passwordError = "Debe completar todos los campos de contraseña.";
        }

        // Validar fuerza
        if (!$passwordError) {
            $regex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
            if (!preg_match($regex, $pwdNueva)) {
                $passwordError = "La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un símbolo.";
            }
        }

        if (!$passwordError && $pwdNueva !== $pwdConf) {
            $passwordError = "Las contraseñas nuevas no coinciden.";
        }

        // Obtener hash actual
        if (!$passwordError) {
            $stmt = $pdo->prepare("CALL sp_obtener_contrasena_persona(?)");
            $stmt->execute([$id_persona]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            if (!$data || !password_verify($pwdActual, $data['contrasena'])) {
                $passwordError = "La contraseña actual es incorrecta.";
            }
        }

        // Guardar nueva contraseña
        if (!$passwordError) {
            $hash = password_hash($pwdNueva, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("CALL sp_actualizar_contrasena(?, ?)");
            $stmt->execute([$id_persona, $hash]);
            $stmt->closeCursor();
        }
    }


    if (!$passwordError) {

        if ($fromPerfil) {
            header("Location: /pages/dashboard.php");
        } else {
            header("Location: listado.php");
        }
        exit;
    }
}

ob_start();
?>

<div class="container-fluid page-inner">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Editar Usuario</h1>
        <a href="/pages/usuarios/listado.php" class="btn btn-secondary">← Volver</a>
    </div>

    <div class="card shadow-sm p-4">
        <form method="POST">

            <!-- DATOS PERSONALES -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Primer apellido</label>
                    <input name="apellido1" class="form-control" value="<?= htmlspecialchars($usuario['apellido1']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Segundo apellido</label>
                    <input name="apellido2" class="form-control" value="<?= htmlspecialchars($usuario['apellido2']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cédula</label>
                    <input name="cedula" class="form-control" value="<?= htmlspecialchars($usuario['cedula']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="1" <?= $usuario['id_estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= $usuario['id_estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
            </div>

            <?php if (!$fromPerfil): ?>

                <br><br>
                <h5 class="fw-bold">Rol del usuario</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Rol</label>
                        <select name="rol_id" class="form-select" required>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['id'] ?>"
                                        <?= ($rol['id'] == $rolActualId) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($rol['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <?php endif; ?>



            <br>
            <br>

            <!-- CORREOS -->
            <h5 class="fw-bold">Correos electrónicos</h5>
            <div id="correos-container">
                <?php foreach ($correos as $c): ?>
                    <div class="row g-2 mb-2">
                        <div class="col-md-6"><input class="form-control" value="<?= htmlspecialchars($c['correo']) ?>" disabled></div>
                        <div class="col-md-4"><input class="form-control" value="<?= htmlspecialchars($c['descripcion']) ?>" disabled></div>
                        <div class="col-md-2">
                            <a href="#"
                               class="btn btn-outline-danger w-100"
                               onclick="confirmarEliminacion('correo', 'editar.php?id=<?= $id_persona ?>&del_correo=<?= $c['id'] ?>')">
                                ✖
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="agregarCorreo()">Agregar correo</button>

            <br>
            <br>
            <br>

            <!-- TELÉFONOS -->
            <h5 class="fw-bold">Teléfonos</h5>
            <div id="telefonos-container">
                <?php foreach ($telefonos as $t): ?>
                    <div class="row g-2 mb-2 telefono-row">
                        <div class="col-md-5">
                            <input name="telefono_existente[<?= $t['id'] ?>]"
                                   class="form-control telefono-input"
                                   value="<?= htmlspecialchars($t['telefono']) ?>" readonly>
                        </div>
                        <div class="col-md-5">
                            <select name="telefono_tipo_existente[<?= $t['id'] ?>]"
                                    class="form-select telefono-select d-none">
                                        <?php foreach ($tiposTelefono as $tt): ?>
                                    <option value="<?= $tt['id'] ?>" <?= $tt['id'] == $t['id_telefono_tipo'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tt['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input class="form-control telefono-tipo-text" value="<?= htmlspecialchars($t['tipo']) ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <a href="#"
                               class="btn btn-outline-danger w-100"
                               onclick="confirmarEliminacion('telefono', 'editar.php?id=<?= $id_persona ?>&del_tel=<?= $t['id'] ?>')">
                                ✖
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="agregarTelefono()">Agregar teléfono</button>


            <br>
            <br>
            <br>


            <?php if (isset($_SESSION['id_persona']) && $_SESSION['id_persona'] == $id_persona): ?>

                <h5 class="fw-bold">Cambiar contraseña (opcional)</h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Contraseña actual</label>
                        <input type="password" name="password_actual" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nueva contraseña</label>
                        <input type="password" name="password_nueva" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmar" class="form-control">
                    </div>
                </div>

                <small class="text-muted d-block mt-2">
                    Mínimo 8 caracteres, una mayúscula, un número y un símbolo.
                </small>

            <?php endif; ?>
            <!--<h5 class="fw-bold">Cambiar contraseña (opcional)</h5>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Contraseña actual</label>
                    <input type="password" name="password_actual" class="form-control">
                </div>
            
                <div class="col-md-4">
                    <label class="form-label">Nueva contraseña</label>
                    <input type="password" name="password_nueva" class="form-control">
                </div>
            
                <div class="col-md-4">
                    <label class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmar" class="form-control">
                </div>
            </div>
            
            <small class="text-muted d-block mt-2">
                Mínimo 8 caracteres, una mayúscula, un número y un símbolo.
            </small>-->

            <br>

            <?php if ($passwordError): ?>
                <!-- start:: Static Modal -->
                <div class="modal fade" id="passwordErrorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">
                                    Error al cambiar la contraseña
                                </h5>
                                <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ri-close-large-line fw-semibold"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">
                                    <?= htmlspecialchars($passwordError) ?>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary px-4">Guardar cambios</button>


                <?php if ($fromPerfil): ?>
                    <a href="/pages/dashboard.php" class="btn btn-light">Cancelar</a>
                <?php else: ?>
                    <a href="/pages/usuarios/listado.php" class="btn btn-light">Cancelar</a>
                <?php endif; ?>
            </div>

        </form>

    </div>


    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="confirmDeleteTitle">
                        Confirmar eliminación
                    </h5>
                    <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ri-close-large-line fw-semibold"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmDeleteMessage" class="mb-0">
                        ¿Está seguro que desea eliminar este elemento?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>    
</div>

<script>

    const opcionesTelefono = `<?= $opcionesTelefonoHTML ?>`;

    document.querySelectorAll('.telefono-row').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.querySelector('.telefono-input').readOnly = false;
            row.querySelector('.telefono-select').classList.remove('d-none');
            row.querySelector('.telefono-tipo-text').classList.add('d-none');
        });
        row.addEventListener('mouseleave', () => {
            row.querySelector('.telefono-input').readOnly = true;
            row.querySelector('.telefono-select').classList.add('d-none');
            row.querySelector('.telefono-tipo-text').classList.remove('d-none');
        });
    });

    function agregarCorreo() {
        document.getElementById('correos-container').insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2">
            <div class="col-md-6">
                <input type="email"
                       name="nuevo_correo[]"
                       class="form-control"
                       placeholder="correo@dominio.com"
                       required>
            </div>

            <div class="col-md-4">
                <select name="correo_desc[]" class="form-select" required>
                    <option value="SECUNDARIO" selected>Secundario</option>
                    <option value="PRINCIPAL">Principal</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-outline-secondary w-100"
                        onclick="this.closest('.row').remove()">—</button>
            </div>
        </div>
    `);
    }

    function agregarTelefono() {
        document.getElementById('telefonos-container').insertAdjacentHTML('beforeend', `
    <div class="row g-2 mb-2">
        <div class="col-md-5"><input name="nuevo_telefono[]" class="form-control" required></div>
        <div class="col-md-5">
            <select name="telefono_tipo[]" class="form-select" required>${opcionesTelefono}</select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-secondary w-100"
            onclick="this.closest('.row').remove()">—</button>
        </div>
    </div>`);
    }




    let deleteUrl = '';

    function confirmarEliminacion(tipo, url) {
        deleteUrl = url;

        const title = document.getElementById('confirmDeleteTitle');
        const message = document.getElementById('confirmDeleteMessage');

        if (tipo === 'correo') {
            title.textContent = 'Eliminar correo';
            message.textContent = '¿Está seguro que desea eliminar este correo electrónico?';
        } else if (tipo === 'telefono') {
            title.textContent = 'Eliminar teléfono';
            message.textContent = '¿Está seguro que desea eliminar este número de teléfono?';
        } else {
            title.textContent = 'Confirmar eliminación';
            message.textContent = '¿Está seguro que desea eliminar este elemento?';
        }

        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (deleteUrl) {
            window.location.href = deleteUrl;
        }
    });
</script>


<?php if ($passwordError): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = new bootstrap.Modal(document.getElementById('passwordErrorModal'));
            modal.show();
        });
    </script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
