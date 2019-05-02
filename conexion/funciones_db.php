<?php
require_once('db_abstract_model.php');

class FuncionesDB extends DBAbstractModel
{
    public function __construct() {
        $this->db_name = 'SIHOWINXE';
    }
    
    public function consulta(){
        $this->open_connection();
        
        $this->query = "SELECT * FROM HPREGHIST
						ORDER BY FOLIO_PAC
						OFFSET 0 ROWS
						FETCH NEXT 30 ROWS ONLY";
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>!!!!  NO HAY DATOS PARA MOSTRAR !!!!!<br>";
        } else {
            echo "<br>Sí HAY DATOS!!!!<br>";
            echo '<html><body><center><table border="1" cellspacing="0">';
            foreach( sqlsrv_field_metadata( $this->res ) as $fieldMetadata ) {
                foreach( $fieldMetadata as $name => $value) {
                    if ($name == "Name") {
                        echo "<th> $value </th>";
                    }
                }
            }
            //echo "</tr";
            while($fila=sqlsrv_fetch_array($this->res)){
                echo '<tr>';
                echo '<td>'. $fila['FOLIO_PAC'] . '</td>';
                echo '<td>'. $fila['DESC_PAC'] . '</td>';
                echo '<td>'. $fila['APE_PAT_PAC'] . '</td>';
                echo '<td>'. $fila['APE_MAT_PAC'] . '</td>';
                $fecha_ingr = $fila['FEC_INGRESO']->format('d/m/Y H:i:s');
                echo '<td>'. $fecha_ingr . '</td>';
                $fecha_egr = $fila['FEC_EGRESO']->format('d/m/Y H:i:s');
                echo '<td>'. $fecha_egr . '</td>';
                $fecha_baja = $fila['FEC_BAJA']->format('d/m/Y H:i:s');
                echo '<td>'. $fecha_baja . '</td>';
                echo '<td>'. $fila['ID_USR_BAJA'] . '</td>';
                echo '<td>'. $fila['OBLI_PAC'] . '</td>';
                echo '<td>'. $fila['MOTIVO'] . '</td>';
                echo '</tr>';
            }
            echo '</center></table></body></html>';
        }
        $this->close_connection();
    }
    
    public function consultaBasicos($Expediente, $Folio){
        $this->open_connection();
        $filtroFolio= ($Folio == NULL )? "":"AND FOLIO_PAC LIKE '%$Folio'";
        $expCort=substr($Expediente,2);
        $this->query = "SELECT * FROM (
        				SELECT FOLIO_PAC, RTRIM(CASE WHEN APE_PAT_PAC IS NULL THEN '' ELSE APE_PAT_PAC END) + ' ' + RTRIM(CASE WHEN APE_MAT_PAC IS NULL 
                        THEN '' ELSE APE_MAT_PAC END) + ' ' + RTRIM(CASE WHEN DESC_PAC IS NULL THEN '' ELSE DESC_PAC END) AS NOMBRE, DESC_PAC, APE_PAT_PAC, 
                        APE_MAT_PAC, EDAD_PAC, NACIO_PA, SEXO_PAC, FEC_ING_PAC, HR_ING_PAC, FEC_SAL_REG05 AS FEC_SAL, NO_EXP_PAC, FEC_HOSP_PAC, MOTIV_ING_PAC, P.CVE_MEDICO, 
                        M.DESC_MEDICO, M.CEDULA_MEDICO, M.DESC_ESPEC, P.CVE_MEDICO_REM, P.CVE_CUARTO, DIR_PAC, COL_PAC, CD_PAC, CP_PAC, OBLI_PAC, TEL_PAC,
						DATO_OPCIONAL8_PAC
                        FROM dbo.HPREG05 AS P
                        LEFT JOIN dbo.VHP_DATOSDEMEDICOS AS M ON P.CVE_MEDICO=M.CVE_MEDICO
                        WHERE (NO_EXP_PAC = '$Expediente' OR NO_EXP_PAC LIKE '%$Expediente' OR NO_EXP_PAC LIKE '%$expCort') $filtroFolio --AND FEC_ING_PAC=(SELECT MAX(FEC_ING_PAC) FROM dbo.HPREG05 WHERE NO_EXP_PAC LIKE '%$Expediente')
                        UNION 
                        SELECT FOLIO_PAC, RTRIM(CASE WHEN APE_PAT_PAC IS NULL THEN '' ELSE APE_PAT_PAC END) + ' ' + RTRIM(CASE WHEN APE_MAT_PAC IS NULL 
                        THEN '' ELSE APE_MAT_PAC END) + ' ' + RTRIM(CASE WHEN DESC_PAC IS NULL THEN '' ELSE DESC_PAC END) AS NOMBRE, DESC_PAC, APE_PAT_PAC, 
                        APE_MAT_PAC, EDAD_PAC, NACIO_PA, SEXO_PAC, FEC_ING_PAC, HR_ING_PAC, FEC_SAL_REG07 AS FEC_SAL, NO_EXP_PAC, FEC_HOSP_PAC, MOTIV_ING_PAC, P.CVE_MEDICO, 
                        M.DESC_MEDICO, M.CEDULA_MEDICO, M.DESC_ESPEC, P.CVE_MEDICO_REM, P.CVE_CUARTO, DIR_PAC, COL_PAC, CD_PAC, CP_PAC, OBLI_PAC, TEL_PAC,
						DATO_OPCIONAL8_PAC
                        FROM dbo.HPREG07 AS P
                        LEFT JOIN dbo.VHP_DATOSDEMEDICOS AS M ON P.CVE_MEDICO=M.CVE_MEDICO
                        WHERE (NO_EXP_PAC = '$Expediente' OR NO_EXP_PAC LIKE '%$Expediente' OR NO_EXP_PAC LIKE '%$expCort') $filtroFolio --AND FEC_ING_PAC=(SELECT MAX(FEC_ING_PAC) FROM dbo.HPREG07 WHERE NO_EXP_PAC LIKE '%$Expediente')
                        ) AS T ORDER BY FEC_ING_PAC DESC"; #OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY";
        #echo 'QUERRRYYYYY!!!!!: '.$this->query;
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS PARA MOSTRAR<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }

	public function medicamento($search){
        $this->open_connection();
        
        $this->query = "SELECT p.CVE_PROD, p.DESC_PROD, p.CVE_GRUPO, g.DESC_GRUPO, p.CLAVE_SAL, s.NOMBRE_SAL, a.EXIS_PZA_PROD, p.ALTORIESGO
						FROM dbo.HPCATPROD AS p
						LEFT JOIN HPSAL_PRODUCTO AS s ON p.CLAVE_SAL=s.CLAVE_SAL
						LEFT JOIN HPGRUPO AS g ON p.CVE_GRUPO=g.CVE_GRUPO
						LEFT JOIN VHP_CATPROD_ALMACENES AS a ON p.CVE_PROD=a.CVE_PROD
						WHERE p.CVE_MACRO ='12' AND p.DESC_PROD LIKE '%" . $search . "%' AND CVE_ALM='1' AND p.ACTIVO_PROD=0 --AND p.CVE_GRUPO IS NOT NULL
						ORDER BY p.DESC_PROD";
        /*"SELECT CVE_PROD,DESC_PROD 
        FROM dbo.HPCATPROD 
        WHERE CVE_MACRO ='12' AND DESC_PROD LIKE '" . $search . "%'
        ORDER BY DESC_PROD";*/
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION MEDICAMENTO<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }
    
    public function material($search){
        $this->open_connection();
        
        $this->query = "SELECT CVE_PROD, DESC_PROD, p.CVE_GRUPO, g.DESC_GRUPO
						FROM dbo.HPCATPROD AS p
						LEFT JOIN HPGRUPO AS g ON p.CVE_GRUPO=g.CVE_GRUPO
						WHERE p.CVE_MACRO=13 AND DESC_PROD LIKE '" . $search . "%'  
							AND p.CVE_GRUPO NOT IN('H5','G2','H1', 'F9', 'F8', 'H3', 'G3', 'F5', 'G0', 'F7', 'G8', 'H2', 'H4', 'H6', 'H7')
						ORDER BY P.DESC_PROD";
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION MEDICAMENTO<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }
	
	public function medicos($search){
        $this->open_connection();
        
        $this->query = "SELECT CVE_MEDICO, DESC_MEDICO, DESC_ESPEC, TEL_PART_MEDICO, EMAIL_MEDICO
						FROM dbo.VHP_DATOSDEMEDICOS
						WHERE DESC_MEDICO LIKE '" . $search . "%'
						ORDER BY DESC_MEDICO";
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION MEDICO<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }
	
	public function medicosCed($search){
		if(strlen($search) <= 4) {
			return false;
		} else {
			$this->open_connection();

			$this->query = "SELECT CVE_MEDICO, DESC_MEDICO, DESC_ESPEC, CEDULA_MEDICO, TEL_PART_MEDICO, EMAIL_MEDICO, UNIVERSIDAD_CEDULA_MEDICO
							FROM dbo.VHP_MEDICOINSTRU_UNION
							WHERE CEDULA_MEDICO = '$search ' OR CEDULA2_MEDICO = '$search ' OR CEDULA3_MEDICO = '$search '
							ORDER BY UNIVERSIDAD_CEDULA_MEDICO desc";

			$this->res=sqlsrv_query($this->conn,$this->query);

			if (!$this->res) {
				echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION MEDICO_CEDULA<br>";
				return false;
			} else {
				$json = array();
				while($fila=sqlsrv_fetch_array($this->res)){
					$json[] = ($fila);
				}
				return $json;
			}
			$this->close_connection();
		}
    }
	
	public function medicosCedB($search){
        $this->open_connection();
        
        $this->query = "SELECT CVE_MEDICO, DESC_MEDICO, DESC_ESPEC, CEDULA_MEDICO, TEL_PART_MEDICO, EMAIL_MEDICO, UNIVERSIDAD_CEDULA_MEDICO
						FROM dbo.VHP_MEDICOINSTRU_UNION
						WHERE CEDULA_MEDICO LIKE '%$search% ' OR CEDULA2_MEDICO LIKE '%$search% ' OR CEDULA3_MEDICO LIKE '%$search% '";
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION MEDICO_CEDULA<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }
	
	public function listaConsulta($fecha){
		$fecha1=$fecha.'T00:00:00';
		$fecha2=$fecha.'T23:59:59';
        $this->open_connection();
        
        $this->queryCons = "SELECT * FROM (
			SELECT NO_EXP_PAC, FOLIO_PAC, 
			RTRIM(CASE WHEN APE_PAT_PAC IS NULL THEN '' ELSE APE_PAT_PAC END)+ ' ' + RTRIM(CASE WHEN APE_MAT_PAC IS NULL THEN '' ELSE APE_MAT_PAC END) + ' ' + RTRIM(CASE WHEN DESC_PAC IS NULL THEN '' ELSE DESC_PAC END) AS NOMBRE, FEC_ING_PAC, HR_ING_PAC
			FROM dbo.HPREG07
			WHERE VIA_ING_PAC IN(1,8,9,13) AND FEC_ING_PAC BETWEEN '$fecha1' AND '$fecha2'
			UNION
			SELECT NO_EXP_PAC, FOLIO_PAC,
			RTRIM(CASE WHEN APE_PAT_PAC IS NULL THEN '' ELSE APE_PAT_PAC END)+ ' ' + RTRIM(CASE WHEN APE_MAT_PAC IS NULL THEN '' 
			ELSE APE_MAT_PAC END) + ' ' + RTRIM(CASE WHEN DESC_PAC IS NULL THEN '' ELSE DESC_PAC END) AS NOMBRE, FEC_ING_PAC, HR_ING_PAC
			FROM dbo.HPREG05
			WHERE VIA_ING_PAC IN(1,8,9,13) AND FEC_ING_PAC BETWEEN '$fecha1' AND '$fecha2' )AS T ORDER BY HR_ING_PAC";
        
        $this->resCons=sqlsrv_query($this->conn,$this->queryCons);
        
        if (!$this->resCons) {
            echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION Lista Consulta Med<br>".$this->queryCons;
			die( print_r( sqlsrv_errors(), true));
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->resCons)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }
	
	public function listaConsultaFar($fecha, $fecha2){
		$fecha1=$fecha.'T00:00:00';
		$fecha2=$fecha2.'T00:00:00';
        $this->open_connection();
        
        $this->queryCons = "SELECT * FROM (
							SELECT NO_EXP_PAC, FOLIO_PAC, 
							RTRIM(CASE WHEN APE_PAT_PAC IS NULL THEN '' ELSE APE_PAT_PAC END)+ ' ' + 
							RTRIM(CASE WHEN APE_MAT_PAC IS NULL THEN '' ELSE APE_MAT_PAC END) + ' ' + 
							RTRIM(CASE WHEN DESC_PAC IS NULL THEN '' ELSE DESC_PAC END) AS NOMBRE, FEC_ING_PAC, OBLI_PAC,
							r.CVE_PAQUET,p.DESC_PAQUET
							FROM dbo.HPREG07 AS r
							LEFT JOIN dbo.HPPAQUET AS p ON (r.CVE_PAQUET=p.CVE_PAQUET)
							WHERE VIA_ING_PAC IN(1,8,9,13,14,15,16,2,3) AND FEC_ING_PAC BETWEEN '$fecha1' AND '$fecha2' AND FEC_SAL_REG07 IS NULL
							UNION
							SELECT NO_EXP_PAC, FOLIO_PAC,
							RTRIM(CASE WHEN APE_PAT_PAC IS NULL THEN '' ELSE APE_PAT_PAC END)+ ' ' + RTRIM(CASE WHEN APE_MAT_PAC IS NULL THEN '' 
							ELSE APE_MAT_PAC END) + ' ' + RTRIM(CASE WHEN DESC_PAC IS NULL THEN '' ELSE DESC_PAC END) AS NOMBRE, FEC_ING_PAC, OBLI_PAC,
							r.CVE_PAQUET,p.DESC_PAQUET
							FROM dbo.HPREG05 as r
							LEFT JOIN dbo.HPPAQUET AS p ON (r.CVE_PAQUET=p.CVE_PAQUET)
							WHERE VIA_ING_PAC IN(1,8,9,13,14,15,16,2,3) AND FEC_ING_PAC BETWEEN '$fecha1' AND '$fecha2' AND FEC_SAL_REG05 IS NULL ) AS T ORDER BY FEC_ING_PAC";
        
        $this->resCons=sqlsrv_query($this->conn,$this->queryCons);
        
        if (!$this->resCons) {
            echo "<br>NO HAY DATOS PARA MOSTRAR FUNCION Lista Consulta Farmacia<br>".$this->queryCons;
			die( print_r( sqlsrv_errors(), true));
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->resCons)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }
    
    public function medicamentoSurtido($Expediente, $Folio){
        $this->open_connection();
        
        $this->query = "SELECT m.FOLIO_HPMOVTO, m.CONSECUTIVO_LAB, m.FOLIO_PAC, r.NO_EXP_PAC, m.CVE_PROD, p.DESC_PROD, m.CANT, m.IMP_ANT,
						m.COSTO_SAL, m.FECHA, m.fecha_registro, m.HORA, m.DESCUENTO
						FROM vConsHpMovto as m
						LEFT JOIN vConsHpMovto as m2 ON m.FOLIO_PAC=m2.FOLIO_PAC
						LEFT JOIN HPREG07 as r ON m.FOLIO_PAC=r.FOLIO_PAC
						LEFT JOIN HPCONCEP as c ON m.CVE_DET_CONCEP=c.CVE_DET_CONCEP
						LEFT JOIN HPCATPROD as p on m.CVE_PROD=p.CVE_PROD
						WHERE m.CVE_MACRO='12' AND r.NO_EXP_PAC = '$Expediente' AND r.FOLIO_PAC ='$Folio'
						UNION
						SELECT m.FOLIO_HPMOVTO, m.CONSECUTIVO_LAB, m.FOLIO_PAC, r.NO_EXP_PAC, m.CVE_PROD, p.DESC_PROD, m.CANT, m.IMP_ANT,
						m.COSTO_SAL, m.FECHA, m.fecha_registro, m.HORA, m.DESCUENTO
						FROM vConsHpMovto2 as m
						LEFT JOIN HPREG07 as r ON m.FOLIO_PAC=r.FOLIO_PAC
						LEFT JOIN HPCONCEP as c ON m.CVE_DET_CONCEP=c.CVE_DET_CONCEP
						LEFT JOIN HPCATPROD as p on m.CVE_PROD=p.CVE_PROD
						WHERE m.CVE_MACRO='12' AND r.NO_EXP_PAC = '$Expediente' AND r.FOLIO_PAC ='$Folio'";
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS funcion medicamentoSurtidos<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }

	public function datosLaboratorio($expediente,$folio){
        $this->open_connection();
        
        $this->query = "SELECT l.Folio_pac, l.Consecutivo, l.Cve_macro, l.Cve_Det_Concep, l.FECHA_CAPTURA,
						r.consecutivo,r.SECUENCIA, r.RESULTADO,
						l.CVE_MAQUILA,m.DESC_MAQUILA,
						--re.limite_inferior, re.limite_superior,
						P.LIMITE_INFERIOR, P.LIMITE_SUPERIOR,
						p.DESCRIPCION, p.UNIDAD,
						reg.SEXO_PAC,p.SEXO,reg.EDAD_PAC
						FROM LbResultadoHeader_HIST AS l
						LEFT JOIN HPREG07 AS reg ON l.Folio_pac=reg.FOLIO_PAC
						LEFT JOIN LBRESULTADO_HIST as r ON l.Consecutivo=r.consecutivo
						LEFT JOIN LBMAQUILA AS m ON l.CVE_MAQUILA=m.CVE_MAQUILA
						LEFT JOIN V_LBPLANTILLASYREFERENCIAS AS p ON l.Cve_Det_Concep=p.CVE_DET_CONCEP AND l.Cve_macro=p.CVE_MACRO AND r.SECUENCIA=p.SECUENCIA and reg.EDAD_PAC>=P.EDAD AND reg.EDAD_PAC<p.EDAD_MAXIMA
						--LEFT JOIN LBREFERENCIA AS re ON l.Cve_Det_Concep=re.CVE_DET_CONCEP AND l.Cve_macro=re.CVE_MACRO AND r.SECUENCIA=re.SECUENCIA AND l.CVE_MAQUILA=re.CVE_MAQUILA AND reg.SEXO_PAC=re.SEXO
						--LEFT JOIN LBPLANTILLA AS p ON l.Cve_Det_Concep=p.CVE_DET_CONCEP AND l.Cve_macro=p.CVE_MACRO AND r.SECUENCIA=p.SECUENCIA AND p.CVE_MAQUILA=l.CVE_MAQUILA
						WHERE reg.NO_EXP_PAC='$expediente' AND reg.FOLIO_PAC ='$folio' --AND l.Consecutivo='132858'
						UNION
						SELECT l.Folio_pac, l.Consecutivo, l.Cve_macro, l.Cve_Det_Concep, l.FECHA_CAPTURA,
						r.consecutivo,r.SECUENCIA, r.RESULTADO,
						l.CVE_MAQUILA,m.DESC_MAQUILA,
						P.LIMITE_INFERIOR, P.LIMITE_SUPERIOR,
						p.DESCRIPCION, p.UNIDAD,
						reg.SEXO_PAC,p.SEXO,reg.EDAD_PAC
						FROM LbResultadoHeader_HIST AS l
						LEFT JOIN HPREG05 AS reg ON l.Folio_pac=reg.FOLIO_PAC
						LEFT JOIN LBRESULTADO_HIST as r ON l.Consecutivo=r.consecutivo
						LEFT JOIN LBMAQUILA AS m ON l.CVE_MAQUILA=m.CVE_MAQUILA
						LEFT JOIN V_LBPLANTILLASYREFERENCIAS AS p ON l.Cve_Det_Concep=p.CVE_DET_CONCEP AND l.Cve_macro=p.CVE_MACRO AND r.SECUENCIA=p.SECUENCIA and reg.EDAD_PAC>=P.EDAD AND reg.EDAD_PAC<p.EDAD_MAXIMA
						WHERE reg.NO_EXP_PAC='$expediente' AND reg.FOLIO_PAC ='$folio'
						ORDER BY l.FECHA_CAPTURA, l.Consecutivo, r.SECUENCIA";
        
        $this->res=sqlsrv_query($this->conn,$this->query);
        
        if (!$this->res) {
            echo "<br>NO HAY DATOS FUNCION DATOS LABORATORIO<br>";
            return false;
        } else {
            $json = array();
            while($fila=sqlsrv_fetch_array($this->res)){
                $json[] = ($fila);
            }
            return $json;
        }
        $this->close_connection();
    }

}
//$usuario1 = new Usuario();
//$usuario1->consulta();
?>
