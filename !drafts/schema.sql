CREATE TABLE clients (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  source           CHAR(50),
  name             CHAR(50),
  email            CHAR(50),
  first_tel        CHAR(18),
  second_tel       CHAR(18),
  address          CHAR(128),
  note             CHAR(250),
  balance          INT,
  deb              INT,
  cred             INT,
  reg_date         DATE,
  last_notify_date DATE,
  last_order_date  DATE,
  orders_count     INT,
  stuff            CHAR(32)
);


CREATE UNIQUE INDEX name
  ON clients (name);
CREATE UNIQUE INDEX email
  ON clients (email);

CREATE INDEX clients_id
  ON clients (id);
CREATE INDEX clients_name
  ON clients (name);
CREATE INDEX clients_email
  ON clients (email);
CREATE INDEX clients_first_tel
  ON clients (first_tel);


ALTER TABLE rocket_megapolis.clients
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE clients_payments (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  deb             INT,
  cred            INT,
  payment_purpose CHAR(50),
  payment_type    CHAR(50),
  payment_note    CHAR(128),
  payment_date    DATE,
  order_name      CHAR(32),
  client_id       INT,
  stuff           CHAR(32),
  cash_id         INT,
  is_auto_create  TINYINT,
  is_deleted      TINYINT
);


CREATE INDEX clients_payments_id
  ON clients_payments (id);
CREATE INDEX clients_payments_client_id
  ON clients_payments (client_id);
CREATE INDEX clients_payments_payment_purpose
  ON clients_payments (payment_purpose);
CREATE INDEX clients_payments_payment_type
  ON clients_payments (payment_type);
CREATE INDEX clients_payments_payment_date
  ON clients_payments (payment_date);

ALTER TABLE rocket_megapolis.clients_payments
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE cash (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  deb                 INT,
  cred                INT,
  payment_purpose     CHAR(50),
  payment_type        CHAR(50),
  payment_note        CHAR(128),
  payment_date        DATE,
  order_id            INT,
  client_id           INT,
  stuff               CHAR(32),
  clients_payments_id INT,
  is_auto_create      TINYINT,
  is_deleted          TINYINT
);

CREATE INDEX cash_id
ON cash (id);
CREATE INDEX cash_client_id
  ON cash (client_id);
CREATE INDEX cash_payment_purpose
  ON cash (payment_purpose);
CREATE INDEX cash_payment_type
  ON cash (payment_type);
CREATE INDEX cash_payment_date
  ON cash (payment_date);

ALTER TABLE rocket_megapolis.cash
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE cash_remainder (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  payment_type CHAR(50),
  deb          INT,
  cred         INT,
  balance      INT
);


CREATE INDEX cash_remainder_payment_type
  ON cash_remainder (payment_type);

ALTER TABLE rocket_megapolis.cash_remainder
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;

////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE materials (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  deb              FLOAT(1),
  cred             FLOAT(1),
  material_purpose CHAR(50),
  material_name    CHAR(128),
  material_note    CHAR(128),
  action_date      DATE,
  order_name       CHAR(32),
  stuff            CHAR(32),
  is_auto_create   TINYINT,
  is_deleted       TINYINT
);



CREATE INDEX materials_material_purpose
  ON materials (material_purpose);
CREATE INDEX materials_material_name
  ON materials (material_name);
CREATE INDEX materials_action_date
  ON materials (action_date);


ALTER TABLE rocket_megapolis.materials
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE materials_remainder (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  material_name   CHAR(128),
  deb             FLOAT(1),
  cred            FLOAT(1),
  balance         FLOAT(1),
  last_order_date DATE,
  order_quantity  INT
);


CREATE INDEX materials_remainder_material_name
  ON materials_remainder (material_name);

ALTER TABLE rocket_megapolis.materials_remainder
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////

CREATE TABLE print_orders (
  id                    INT AUTO_INCREMENT PRIMARY KEY,
  order_name            CHAR(32),
  order_name_privat     CHAR(100),
  calc_result_file_path CHAR(255),
  client_id             INT,
  total_price           INT,
  square                FLOAT(1),
  hours                 FLOAT(1),
  order_status          CHAR(32),
  order_item_ready      INT,
  order_item_total      INT,
  promo_codes           CHAR(255),
  order_note            CHAR(128),

  need_delivery         TINYINT,
  date_notify           DATE,

  date_create           DATE,
  date_injob            DATE,
  date_ready            DATE,
  date_issued           DATE,
  date_deleted          DATE,

  stuff_create          CHAR(32),
  stuff_conf            CHAR(32)
);


CREATE INDEX print_orders_id
  ON print_orders (id);
CREATE INDEX print_orders_order_name_privat
  ON print_orders (order_name_privat);
CREATE INDEX print_orders_client_id
  ON print_orders (client_id);
CREATE INDEX print_orders_order_status
  ON print_orders (order_status);
CREATE INDEX print_orders_date_create
  ON print_orders (date_create);
CREATE INDEX print_orders_date_injob
  ON print_orders (date_injob);
CREATE INDEX print_orders_date_ready
  ON print_orders (date_ready);
CREATE INDEX print_orders_date_issued
  ON print_orders (date_issued);
CREATE INDEX print_orders_date_deleted
  ON print_orders (date_deleted);

ALTER TABLE rocket_megapolis.print_orders
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE print_order_items (
  id                           INT AUTO_INCREMENT PRIMARY KEY,
  print_order_id               INT,

  date_ready                   DATE,
  date_issued                  DATE,
  date_deleted                 DATE,

  order_item_index             INT,
  material_type                CHAR(100),
  print_type                   CHAR(128),
  order_item_status            CHAR(32),

  total_total_price            INT,
  total_total_hours            FLOAT(1),
  total_material_cost          INT,

  print_quantity               FLOAT(1),
  print_total_price            INT,
  print_hours                  FLOAT(1),

  overspending_quantity        FLOAT(1),
  overspending_total_price     INT,
  overspending_percent         FLOAT(1),

  optional_work_total_price    INT,
  optional_work_hours          FLOAT(1),

  design_price_total_price     INT,

  cringle_quantity             INT,
  cringle_total_price          INT,
  cringle_hours                FLOAT(1),

  gain_quantity                FLOAT(1),
  gain_total_price             INT,
  gain_hours                   FLOAT(1),

  cut_quantity                 FLOAT(1),
  cut_total_price              INT,
  cut_hours                    FLOAT(1),

  cord_quantity                FLOAT(1),
  cord_total_price             INT,
  cord_hours                   FLOAT(1),

  pocket_quantity              FLOAT(1),
  pocket_total_price           INT,
  pocket_hours                 FLOAT(1),

  coupling_quantity            FLOAT(1),
  coupling_total_price         INT,
  coupling_hours               FLOAT(1),

  lamination_quantity          FLOAT(1),
  lamination_total_price       INT,
  lamination_hours             FLOAT(1),

  stick_to_plastic_quantity    FLOAT(1),
  stick_to_plastic_total_price INT,
  stick_to_plastic_hours       FLOAT(1)

);


CREATE INDEX print_order_items_id
  ON print_order_items (id);
CREATE INDEX print_order_items_print_order_id
  ON print_order_items (print_order_id);
CREATE INDEX print_order_items_date_ready
  ON print_order_items (date_ready);
CREATE INDEX print_order_items_date_issued
  ON print_order_items (date_issued);
CREATE INDEX print_order_items_date_deleted
  ON print_order_items (date_deleted);


ALTER TABLE rocket_megapolis.print_order_items
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


CREATE TABLE requests_text (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  request_origin       CHAR(70),
  request_name         CHAR(40),
  request_contact      CHAR(40),
  request_type         CHAR(100),
  request_body         CHAR(250),
  request_status       CHAR(16),
  date_create          DATE,
  date_closed          DATE,
  stuff_request_closed CHAR(32)
);


CREATE INDEX requests_text_request_status
  ON requests_text (request_status);

CREATE INDEX requests_text_date_create
  ON requests_text (date_create);

ALTER TABLE rocket_megapolis.requests_text
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_general_ci;


////////////////////////////////////////////////////////////////////////////////////


