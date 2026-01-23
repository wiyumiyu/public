<?php
$pageTitle = "Nuevo Usuario";
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/config.php';

/* =====================================================
  1️⃣ VARIABLES INICIALES
  ===================================================== */
$passwordError = null;

/* Usuario vacío */
$usuario = [
    'nombre' => '',
    'apellido1' => '',
    'apellido2' => '',
    'cedula' => '',
    'id_estado' => 1
];

$correos = [];
$telefonos = [];

/* =====================================================
  2️⃣ llenar lista de roles
  ===================================================== */

$stmt = $pdo->prepare("CALL sp_listar_roles()");
$stmt->execute();
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* =====================================================
  2️⃣ TIPOS DE TELÉFONO
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
  3️⃣ CREAR USUARIO
  ===================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Validar contraseña obligatoria al crear */
    $pwdNueva = $_POST['password_nueva'] ?? '';
    $pwdConf = $_POST['password_confirmar'] ?? '';

    if (!$pwdNueva || !$pwdConf) {
        $passwordError = "Debe ingresar y confirmar la contraseña.";
    }

    if (!$passwordError) {
        $regex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if (!preg_match($regex, $pwdNueva)) {
            $passwordError = "La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un símbolo.";
        }
    }

    if (empty($_POST['rol_id'])) {
        $passwordError = "Debe seleccionar un rol para el usuario.";
    }

    if (!$passwordError && $pwdNueva !== $pwdConf) {
        $passwordError = "Las contraseñas no coinciden.";
    }

    if (!$passwordError) {

        $hash = password_hash($pwdNueva, PASSWORD_DEFAULT);

        try {



            /* Crear persona */
            $stmt = $pdo->prepare("CALL sp_crear_persona(?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['nombre'],
                $_POST['apellido1'],
                $_POST['apellido2'],
                0,
                $_POST['cedula'],
                '1990-01-01',
                $hash,
                ''
            ]);

            /* Obtener ID creado (viene del SELECT del SP) */
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            $id_persona = $result['id_persona'];

            /* Asignar rol */
            $stmt = $pdo->prepare("CALL sp_asignar_rol_persona(?, ?)");
            $stmt->execute([
                $id_persona,
                $_POST['rol_id']
            ]);
            $stmt->closeCursor();

            /* Correos */
            if (!empty($_POST['nuevo_correo'])) {
                foreach ($_POST['nuevo_correo'] as $i => $correo) {
                    $stmt = $pdo->prepare("CALL sp_agregar_persona_correo(?, ?, ?)");
                    $stmt->execute([
                        $id_persona,
                        $correo,
                        $_POST['correo_desc'][$i]
                    ]);
                    $stmt->closeCursor();
                }
            }

            /* Teléfonos */
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

            header("Location: listado.php");
            exit;
        } catch (PDOException $e) {

            // Error de cédula duplicada
            if ($e->getCode() === '23000') {
                $passwordError = "Ya existe un usuario registrado con esa cédula.";
            } else {
                throw $e; // otros errores reales
            }
        }
    }
}

ob_start();
?>

<div class="container-fluid page-inner">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Nuevo Usuario</h1>
        <a href="/pages/usuarios/listado.php" class="btn btn-secondary">← Volver</a>
    </div>

    <div class="card shadow-sm p-4">
        <form method="POST">

            <!-- DATOS PERSONALES -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input name="nombre" class="form-control"
                           accesskey="" accept=""value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Primer apellido</label>

                    <input name="apellido1" class="form-control"
                           accesskey="" accept=""value="<?= htmlspecialchars($_POST['apellido1'] ?? '') ?>" required>                    
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Segundo apellido</label>
                    <input name="apellido2" class="form-control"
                           accesskey="" accept=""value="<?= htmlspecialchars($_POST['apellido2'] ?? '') ?>" required>     
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cédula</label>
                    <input name="cedula" class="form-control"
                           accesskey="" accept=""value="<?= htmlspecialchars($_POST['cedula'] ?? '') ?>" required>                         
                </div>


            </div>
            <br><br>

            <h5 class="fw-bold">Rol del usuario</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rol</label>
                    <select name="rol_id" class="form-select" required>
                        <option value="">Seleccione un rol</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?= $rol['id'] ?>"
                                    <?= (($_POST['rol_id'] ?? '') == $rol['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($rol['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>  
            <br><br>

            <!-- CONTRASEÑA OBLIGATORIA -->
            <h5 class="fw-bold">Contraseña</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password"
                               name="password_nueva"
                               id="password_nueva"
                               class="form-control"
                               required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_nueva', this)">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirmar contraseña</label>
                    <div class="input-group">
                        <input type="password"
                               name="password_confirmar"
                               id="password_confirmar"
                               class="form-control"
                               required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_confirmar', this)">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <small class="text-muted d-block mt-2">
                Mínimo 8 caracteres, una mayúscula, un número y un símbolo.
            </small>

            <br><br>

            <!-- CORREOS -->
            <h5 class="fw-bold">Correos electrónicos</h5>
            <div id="correos-container"></div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="agregarCorreo()">Agregar correo</button>

            <br><br><br>

            <!-- TELÉFONOS -->
            <h5 class="fw-bold">Teléfonos</h5>
            <div id="telefonos-container"></div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="agregarTelefono()">Agregar teléfono</button>

            <br>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary px-4">Crear usuario</button>
                <a href="/pages/usuarios/listado.php" class="btn btn-light">Cancelar</a>
            </div>

        </form>
    </div>




    <?php if ($passwordError): ?>
        <div class="modal fade" id="passwordErrorModal"
             data-bs-backdrop="static"
             data-bs-keyboard="false"
             tabindex="-1"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            Error al crear el usuario
                        </h5>
                        <button type="button"
                                class="btn-close icon-btn-sm"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            <i class="ri-close-large-line fw-semibold"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            <?= htmlspecialchars($passwordError) ?>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    const opcionesTelefono = `<?= $opcionesTelefonoHTML ?>`;

    function agregarCorreo() {
        document.getElementById('correos-container').insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2">
            <div class="col-md-6">
                <input type="email" name="nuevo_correo[]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <select name="correo_desc[]" class="form-select">
                    <option value="SECUNDARIO" selected>Secundario</option>
                    <option value="PRINCIPAL">Principal</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-secondary w-100"
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
        </div>
    `);
    }

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ri-eye-line');
            icon.classList.add('ri-eye-off-line');
        } else {
            input.type = 'password';
            icon.classList.remove('ri-eye-off-line');
            icon.classList.add('ri-eye-line');
        }
    }
</script>
<?php if ($passwordError): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = new bootstrap.Modal(
                    document.getElementById('passwordErrorModal')
                    );
            modal.show();
        });
    </script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
