export interface Prestamo {
  id:                        number;
  created_at:                Date;
  updated_at:                Date;
  libro_id:                  number;
  nombre_lector:             string;
  email_lector:              string;
  fecha_prestamo:            Date;
  fecha_devolucion_prevista: Date;
  fecha_devolucion_real:     Date;
  observaciones:             string;
  esta_disponible:           boolean;
}
