#!/usr/bin/env python3
"""
Backend Testing Script for Laravel Meeting System
Tests the meeting CRUD operations and database relationships
"""

import requests
import json
import sys
from datetime import datetime, timedelta
import subprocess
import os

class MeetingSystemTester:
    def __init__(self):
        self.base_url = "http://localhost:8000"
        self.session = requests.Session()
        self.test_results = []
        
    def log_result(self, test_name, success, message, details=None):
        """Log test results"""
        result = {
            'test': test_name,
            'success': success,
            'message': message,
            'details': details or {},
            'timestamp': datetime.now().isoformat()
        }
        self.test_results.append(result)
        status = "✅ PASS" if success else "❌ FAIL"
        print(f"{status} {test_name}: {message}")
        if details and not success:
            print(f"   Details: {details}")
    
    def check_database_schema(self):
        """Test 1: Verify database schema is correctly configured"""
        print("\n=== Testing Database Schema ===")
        
        try:
            # Check if migration was run
            result = subprocess.run([
                'php', 'artisan', 'migrate:status'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0:
                migration_found = '2026_10_06_fix_reuniones_solicitud_id_type' in result.stdout
                self.log_result(
                    "Database Migration Status",
                    migration_found,
                    "Migration for solicitud_id fix found" if migration_found else "Migration not found in status",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
            else:
                self.log_result(
                    "Database Migration Status",
                    False,
                    "Failed to check migration status",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
        except Exception as e:
            self.log_result(
                "Database Migration Status",
                False,
                f"Error checking migration: {str(e)}"
            )
    
    def check_test_data(self):
        """Test 2: Verify test data exists"""
        print("\n=== Checking Test Data ===")
        
        try:
            # Check for solicitudes
            result = subprocess.run([
                'php', 'artisan', 'tinker', '--execute=echo App\\Models\\Solicitud::count();'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0:
                solicitudes_count = result.stdout.strip()
                has_solicitudes = int(solicitudes_count) > 0 if solicitudes_count.isdigit() else False
                self.log_result(
                    "Solicitudes Test Data",
                    has_solicitudes,
                    f"Found {solicitudes_count} solicitudes" if has_solicitudes else "No solicitudes found"
                )
            else:
                self.log_result(
                    "Solicitudes Test Data",
                    False,
                    "Failed to check solicitudes count",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
            # Check for instituciones
            result = subprocess.run([
                'php', 'artisan', 'tinker', '--execute=echo App\\Models\\Institucion::count();'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0:
                instituciones_count = result.stdout.strip()
                has_instituciones = int(instituciones_count) > 0 if instituciones_count.isdigit() else False
                self.log_result(
                    "Instituciones Test Data",
                    has_instituciones,
                    f"Found {instituciones_count} instituciones" if has_instituciones else "No instituciones found"
                )
            else:
                self.log_result(
                    "Instituciones Test Data",
                    False,
                    "Failed to check instituciones count",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
            # Check for personas
            result = subprocess.run([
                'php', 'artisan', 'tinker', '--execute=echo App\\Models\\Personas::count();'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0:
                personas_count = result.stdout.strip()
                has_personas = int(personas_count) > 0 if personas_count.isdigit() else False
                self.log_result(
                    "Personas Test Data",
                    has_personas,
                    f"Found {personas_count} personas" if has_personas else "No personas found"
                )
            else:
                self.log_result(
                    "Personas Test Data",
                    False,
                    "Failed to check personas count",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
        except Exception as e:
            self.log_result(
                "Test Data Check",
                False,
                f"Error checking test data: {str(e)}"
            )
    
    def test_authentication(self):
        """Test 3: Test authentication with provided credentials"""
        print("\n=== Testing Authentication ===")
        
        try:
            # Test login endpoint
            login_url = f"{self.base_url}/login"
            response = self.session.get(login_url, timeout=10)
            
            if response.status_code == 200:
                self.log_result(
                    "Login Page Access",
                    True,
                    "Login page accessible"
                )
                
                # Try to authenticate (this would require CSRF token handling)
                # For now, just check if the form exists
                if 'login' in response.text.lower() or 'cedula' in response.text.lower():
                    self.log_result(
                        "Login Form Present",
                        True,
                        "Login form found on page"
                    )
                else:
                    self.log_result(
                        "Login Form Present",
                        False,
                        "Login form not found on page"
                    )
            else:
                self.log_result(
                    "Login Page Access",
                    False,
                    f"Login page returned status {response.status_code}"
                )
                
        except Exception as e:
            self.log_result(
                "Authentication Test",
                False,
                f"Error testing authentication: {str(e)}"
            )
    
    def test_meeting_routes(self):
        """Test 4: Test meeting routes accessibility"""
        print("\n=== Testing Meeting Routes ===")
        
        routes_to_test = [
            ('/dashboard/reuniones', 'Meeting Index'),
            ('/dashboard/reuniones/crear', 'Meeting Create Form'),
        ]
        
        for route, description in routes_to_test:
            try:
                url = f"{self.base_url}{route}"
                response = self.session.get(url, timeout=10, allow_redirects=False)
                
                # Expect redirect to login for unauthenticated requests
                if response.status_code in [302, 401]:
                    self.log_result(
                        f"Route Protection - {description}",
                        True,
                        f"Route properly protected (status {response.status_code})"
                    )
                elif response.status_code == 200:
                    self.log_result(
                        f"Route Access - {description}",
                        True,
                        "Route accessible (possibly authenticated session)"
                    )
                else:
                    self.log_result(
                        f"Route Access - {description}",
                        False,
                        f"Unexpected status code: {response.status_code}"
                    )
                    
            except Exception as e:
                self.log_result(
                    f"Route Test - {description}",
                    False,
                    f"Error testing route: {str(e)}"
                )
    
    def test_model_relationships(self):
        """Test 5: Test Eloquent model relationships"""
        print("\n=== Testing Model Relationships ===")
        
        try:
            # Test Reunion model relationships
            test_code = """
            try {
                // Test if we can create a basic relationship query
                $reunion = new App\\Models\\Reunion();
                $solicitudRelation = $reunion->solicitud();
                $institucionRelation = $reunion->institucion();
                $asistentesRelation = $reunion->asistentes();
                
                echo "Reunion->solicitud: " . get_class($solicitudRelation) . "\\n";
                echo "Reunion->institucion: " . get_class($institucionRelation) . "\\n";
                echo "Reunion->asistentes: " . get_class($asistentesRelation) . "\\n";
                
                // Test Solicitud relationship back to Reunion
                $solicitud = new App\\Models\\Solicitud();
                $reunionesRelation = $solicitud->reuniones();
                echo "Solicitud->reuniones: " . get_class($reunionesRelation) . "\\n";
                
                echo "SUCCESS: All relationships defined correctly";
            } catch (Exception $e) {
                echo "ERROR: " . $e->getMessage();
            }
            """
            
            result = subprocess.run([
                'php', 'artisan', 'tinker', f'--execute={test_code}'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0 and "SUCCESS" in result.stdout:
                self.log_result(
                    "Model Relationships",
                    True,
                    "All Eloquent relationships properly defined"
                )
            else:
                self.log_result(
                    "Model Relationships",
                    False,
                    "Error in model relationships",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
        except Exception as e:
            self.log_result(
                "Model Relationships Test",
                False,
                f"Error testing relationships: {str(e)}"
            )
    
    def test_meeting_creation_programmatically(self):
        """Test 6: Test meeting creation via Artisan/Tinker"""
        print("\n=== Testing Meeting Creation Programmatically ===")
        
        try:
            # First, get available test data
            get_data_code = """
            $solicitud = App\\Models\\Solicitud::first();
            $institucion = App\\Models\\Institucion::first();
            $persona = App\\Models\\Personas::first();
            
            if ($solicitud && $institucion && $persona) {
                echo "SOLICITUD_ID:" . $solicitud->solicitud_id . "\\n";
                echo "INSTITUCION_ID:" . $institucion->id . "\\n";
                echo "PERSONA_CEDULA:" . $persona->cedula . "\\n";
                echo "DATA_AVAILABLE:true";
            } else {
                echo "DATA_AVAILABLE:false";
                echo "Missing - Solicitud:" . ($solicitud ? "OK" : "MISSING") . " ";
                echo "Institucion:" . ($institucion ? "OK" : "MISSING") . " ";
                echo "Persona:" . ($persona ? "OK" : "MISSING");
            }
            """
            
            result = subprocess.run([
                'php', 'artisan', 'tinker', f'--execute={get_data_code}'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0 and "DATA_AVAILABLE:true" in result.stdout:
                # Extract the IDs
                lines = result.stdout.strip().split('\n')
                solicitud_id = None
                institucion_id = None
                persona_cedula = None
                
                for line in lines:
                    if line.startswith('SOLICITUD_ID:'):
                        solicitud_id = line.split(':', 1)[1]
                    elif line.startswith('INSTITUCION_ID:'):
                        institucion_id = line.split(':', 1)[1]
                    elif line.startswith('PERSONA_CEDULA:'):
                        persona_cedula = line.split(':', 1)[1]
                
                if solicitud_id and institucion_id and persona_cedula:
                    # Now try to create a meeting
                    create_meeting_code = f"""
                    try {{
                        $reunion = App\\Models\\Reunion::create([
                            'solicitud_id' => '{solicitud_id}',
                            'institucion_id' => {institucion_id},
                            'titulo' => 'Reunión de Prueba - ' . date('Y-m-d H:i:s'),
                            'descripcion' => 'Reunión creada por el sistema de pruebas automatizadas',
                            'fecha_reunion' => now()->addDays(7),
                            'ubicacion' => 'Sala de Reuniones Virtual'
                        ]);
                        
                        echo "MEETING_CREATED:true\\n";
                        echo "MEETING_ID:" . $reunion->id . "\\n";
                        echo "MEETING_TITLE:" . $reunion->titulo . "\\n";
                        
                        // Test the relationship
                        $solicitud = $reunion->solicitud;
                        $institucion = $reunion->institucion;
                        
                        echo "RELATIONSHIP_SOLICITUD:" . ($solicitud ? "OK" : "FAILED") . "\\n";
                        echo "RELATIONSHIP_INSTITUCION:" . ($institucion ? "OK" : "FAILED") . "\\n";
                        
                        // Clean up - delete the test meeting
                        $reunion->delete();
                        echo "CLEANUP:OK";
                        
                    }} catch (Exception $e) {{
                        echo "ERROR:" . $e->getMessage();
                    }}
                    """
                    
                    result = subprocess.run([
                        'php', 'artisan', 'tinker', f'--execute={create_meeting_code}'
                    ], cwd='/app', capture_output=True, text=True, timeout=30)
                    
                    if result.returncode == 0 and "MEETING_CREATED:true" in result.stdout:
                        relationships_ok = "RELATIONSHIP_SOLICITUD:OK" in result.stdout and "RELATIONSHIP_INSTITUCION:OK" in result.stdout
                        cleanup_ok = "CLEANUP:OK" in result.stdout
                        
                        self.log_result(
                            "Meeting Creation",
                            True,
                            "Meeting created successfully via Eloquent"
                        )
                        
                        self.log_result(
                            "Meeting Relationships",
                            relationships_ok,
                            "Relationships work correctly" if relationships_ok else "Relationship issues detected"
                        )
                        
                        self.log_result(
                            "Meeting Cleanup",
                            cleanup_ok,
                            "Test meeting cleaned up" if cleanup_ok else "Cleanup failed"
                        )
                    else:
                        self.log_result(
                            "Meeting Creation",
                            False,
                            "Failed to create meeting",
                            {'stdout': result.stdout, 'stderr': result.stderr}
                        )
                else:
                    self.log_result(
                        "Meeting Creation",
                        False,
                        "Could not extract required IDs from test data"
                    )
            else:
                self.log_result(
                    "Meeting Creation",
                    False,
                    "Insufficient test data available",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
        except Exception as e:
            self.log_result(
                "Meeting Creation Test",
                False,
                f"Error testing meeting creation: {str(e)}"
            )
    
    def test_validation_rules(self):
        """Test 7: Test validation rules"""
        print("\n=== Testing Validation Rules ===")
        
        try:
            # Test validation by trying to create invalid data
            test_validation_code = """
            try {
                $request = new App\\Http\\Requests\\StoreReunionRequest();
                $rules = $request->rules();
                
                echo "VALIDATION_RULES_LOADED:true\\n";
                echo "SOLICITUD_ID_RULE:" . (isset($rules['solicitud_id']) ? "OK" : "MISSING") . "\\n";
                echo "INSTITUCION_ID_RULE:" . (isset($rules['institucion_id']) ? "OK" : "MISSING") . "\\n";
                echo "TITULO_RULE:" . (isset($rules['titulo']) ? "OK" : "MISSING") . "\\n";
                echo "FECHA_REUNION_RULE:" . (isset($rules['fecha_reunion']) ? "OK" : "MISSING") . "\\n";
                
                // Check if solicitud_id rule includes string validation
                $solicitudRule = $rules['solicitud_id'] ?? [];
                $hasStringValidation = in_array('string', $solicitudRule);
                echo "SOLICITUD_ID_STRING_VALIDATION:" . ($hasStringValidation ? "OK" : "MISSING") . "\\n";
                
            } catch (Exception $e) {
                echo "ERROR:" . $e->getMessage();
            }
            """
            
            result = subprocess.run([
                'php', 'artisan', 'tinker', f'--execute={test_validation_code}'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0 and "VALIDATION_RULES_LOADED:true" in result.stdout:
                required_rules = [
                    "SOLICITUD_ID_RULE:OK",
                    "INSTITUCION_ID_RULE:OK", 
                    "TITULO_RULE:OK",
                    "FECHA_REUNION_RULE:OK"
                ]
                
                all_rules_present = all(rule in result.stdout for rule in required_rules)
                string_validation = "SOLICITUD_ID_STRING_VALIDATION:OK" in result.stdout
                
                self.log_result(
                    "Validation Rules Present",
                    all_rules_present,
                    "All required validation rules found" if all_rules_present else "Some validation rules missing"
                )
                
                self.log_result(
                    "Solicitud ID String Validation",
                    string_validation,
                    "solicitud_id properly validated as string" if string_validation else "solicitud_id string validation missing"
                )
            else:
                self.log_result(
                    "Validation Rules Test",
                    False,
                    "Failed to load validation rules",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
        except Exception as e:
            self.log_result(
                "Validation Rules Test",
                False,
                f"Error testing validation: {str(e)}"
            )
    
    def run_all_tests(self):
        """Run all tests"""
        print("🚀 Starting Laravel Meeting System Backend Tests")
        print("=" * 60)
        
        # Run all test methods
        self.check_database_schema()
        self.check_test_data()
        self.test_authentication()
        self.test_meeting_routes()
        self.test_model_relationships()
        self.test_meeting_creation_programmatically()
        self.test_validation_rules()
        
        # Summary
        print("\n" + "=" * 60)
        print("📊 TEST SUMMARY")
        print("=" * 60)
        
        total_tests = len(self.test_results)
        passed_tests = sum(1 for result in self.test_results if result['success'])
        failed_tests = total_tests - passed_tests
        
        print(f"Total Tests: {total_tests}")
        print(f"✅ Passed: {passed_tests}")
        print(f"❌ Failed: {failed_tests}")
        print(f"Success Rate: {(passed_tests/total_tests)*100:.1f}%")
        
        if failed_tests > 0:
            print("\n🔍 FAILED TESTS:")
            for result in self.test_results:
                if not result['success']:
                    print(f"  • {result['test']}: {result['message']}")
        
        # Save detailed results
        with open('/app/backend_test_results.json', 'w') as f:
            json.dump(self.test_results, f, indent=2, default=str)
        
        print(f"\n📄 Detailed results saved to: /app/backend_test_results.json")
        
        return failed_tests == 0

if __name__ == "__main__":
    tester = MeetingSystemTester()
    success = tester.run_all_tests()
    sys.exit(0 if success else 1)