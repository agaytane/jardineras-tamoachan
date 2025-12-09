<?php
require_once __DIR__ . '/../model/modelo.php';

class VistasController {

    private $model;

    public function __construct($conn) {
        $this->model = new VistasModel($conn);
    }

    // Vista AGE_V_PEDIDO_CLIENTE_EMPLEADO
    public function pedidoClienteEmpleado() {
        $datos = $this->model->pedidoClienteEmpleado();
        require __DIR__ . '/../views/vistas_info/client_emp.php';
    }

    // Vista AGE_V_PRODUCTO_GAMA_DETALLE
    public function productoGamaDetalle() {
        $datos = $this->model->productoGamaDetalle();
        require __DIR__ . '/../views/vistas_info/gm_ped.php';
    }

    // Vista AGE_V_DETALLE_PEDIDO_INFO
    public function detallePedidoInfo() {
        $datos = $this->model->detallePedidoInfo();
        require __DIR__ . '/../views/vistas_info/ped_infoa.php';
    }

    // Vista AGE_V_EMPLEADO_OFICINA_PEDIDOS
    public function empleadoOficinaPedidos() {
        $datos = $this->model->empleadoOficinaPedidos();
        require __DIR__ . '/../views/vistas_info/ofi_ped.php';
    }

    // Vista AGE_V_CLIENTE_PEDIDO_PRODUCTOS
    public function clientePedidoProductos() {
        $datos = $this->model->clientePedidoProductos();
        require __DIR__ . '/../views/vistas_info/client_pd_prd.php';
    }
}
