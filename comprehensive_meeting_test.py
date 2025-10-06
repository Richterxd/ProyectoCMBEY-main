#!/usr/bin/env python3
"""
Comprehensive Meeting System Test with Authentication
Tests the complete meeting workflow including authentication
"""

import requests
import json
import sys
from datetime import datetime, timedelta
import subprocess
import re
from bs4 import BeautifulSoup

class ComprehensiveMeetingTester:
    def __init__(self):
        self.base_url = "http://localhost:8000"
        self.session = requests.Session()
        self.test_results = []
        self.csrf_token = None
        self.authenticated = False
        
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
    
    def get_csrf_token(self, response_text):
        """Extract CSRF token from HTML"""
        try:
            soup = BeautifulSoup(response_text, 'html.parser')
            csrf_input = soup.find('input', {'name': '_token'})
            if csrf_input:
                return csrf_input.get('value')
            
            # Try meta tag
            csrf_meta = soup.find('meta', {'name': 'csrf-token'})
            if csrf_meta:
                return csrf_meta.get('content')
                
        except Exception as e:
            print(f"Error extracting CSRF token: {e}")
        return None
    
    def authenticate(self):
        """Test authentication with provided credentials"""
        print("\n=== Testing Authentication ===")
        
        try:
            # Get login page
            login_url = f"{self.base_url}/login"
            response = self.session.get(login_url, timeout=10)
            
            if response.status_code != 200:
                self.log_result(
                    "Authentication - Get Login Page",
                    False,
                    f"Failed to get login page: {response.status_code}"
                )
                return False
            
            # Extract CSRF token
            self.csrf_token = self.get_csrf_token(response.text)
            if not self.csrf_token:
                self.log_result(
                    "Authentication - CSRF Token",
                    False,
                    "Could not extract CSRF token from login page"
                )
                return False
            
            self.log_result(
                "Authentication - CSRF Token",
                True,
                "CSRF token extracted successfully"
            )
            
            # Attempt login with provided credentials
            login_data = {
                '_token': self.csrf_token,
                'cedula': '31082799',
                'password': 'Paralele26$'
            }
            
            response = self.session.post(login_url, data=login_data, timeout=10, allow_redirects=False)
            
            if response.status_code == 302:
                # Check if redirected to dashboard
                location = response.headers.get('Location', '')
                if 'dashboard' in location:
                    self.authenticated = True
                    self.log_result(
                        "Authentication - Login",
                        True,
                        f"Successfully authenticated, redirected to: {location}"
                    )
                    return True
                else:
                    self.log_result(
                        "Authentication - Login",
                        False,
                        f"Login redirect unexpected: {location}"
                    )
            else:
                self.log_result(
                    "Authentication - Login",
                    False,
                    f"Login failed with status: {response.status_code}"
                )
                
        except Exception as e:
            self.log_result(
                "Authentication",
                False,
                f"Authentication error: {str(e)}"
            )
        
        return False
    
    def test_meeting_pages_authenticated(self):
        """Test meeting pages with authentication"""
        print("\n=== Testing Meeting Pages (Authenticated) ===")
        
        if not self.authenticated:
            self.log_result(
                "Meeting Pages Test",
                False,
                "Cannot test - not authenticated"
            )
            return
        
        pages_to_test = [
            ('/dashboard/reuniones', 'Meeting Index Page'),
            ('/dashboard/reuniones/crear', 'Meeting Create Page'),
        ]
        
        for route, description in pages_to_test:
            try:
                url = f"{self.base_url}{route}"
                response = self.session.get(url, timeout=10)
                
                if response.status_code == 200:
                    # Check for expected content
                    content_checks = {
                        'Meeting Index Page': ['reuniones', 'crear', 'Nueva Reunión'],
                        'Meeting Create Page': ['solicitud_id', 'institucion_id', 'titulo', 'fecha_reunion']
                    }
                    
                    expected_content = content_checks.get(description, [])
                    content_found = all(term.lower() in response.text.lower() for term in expected_content)
                    
                    self.log_result(
                        f"Page Access - {description}",
                        True,
                        f"Page accessible (status 200)"
                    )
                    
                    if expected_content:
                        self.log_result(
                            f"Page Content - {description}",
                            content_found,
                            f"Expected content {'found' if content_found else 'missing'}"
                        )
                else:
                    self.log_result(
                        f"Page Access - {description}",
                        False,
                        f"Page returned status {response.status_code}"
                    )
                    
            except Exception as e:
                self.log_result(
                    f"Page Test - {description}",
                    False,
                    f"Error accessing page: {str(e)}"
                )
    
    def test_meeting_creation_via_web(self):
        """Test meeting creation via web form"""
        print("\n=== Testing Meeting Creation via Web Form ===")
        
        if not self.authenticated:
            self.log_result(
                "Web Meeting Creation",
                False,
                "Cannot test - not authenticated"
            )
            return
        
        try:
            # Get the create form
            create_url = f"{self.base_url}/dashboard/reuniones/crear"
            response = self.session.get(create_url, timeout=10)
            
            if response.status_code != 200:
                self.log_result(
                    "Web Meeting Creation - Get Form",
                    False,
                    f"Could not access create form: {response.status_code}"
                )
                return
            
            # Extract CSRF token from form
            form_csrf = self.get_csrf_token(response.text)
            if not form_csrf:
                self.log_result(
                    "Web Meeting Creation - Form CSRF",
                    False,
                    "Could not extract CSRF token from create form"
                )
                return
            
            # Extract available options from form
            soup = BeautifulSoup(response.text, 'html.parser')
            
            # Get first solicitud option
            solicitud_select = soup.find('select', {'name': 'solicitud_id'})
            solicitud_id = None
            if solicitud_select:
                options = solicitud_select.find_all('option')
                for option in options:
                    if option.get('value') and option.get('value') != '':
                        solicitud_id = option.get('value')
                        break
            
            # Get first institucion option
            institucion_select = soup.find('select', {'name': 'institucion_id'})
            institucion_id = None
            if institucion_select:
                options = institucion_select.find_all('option')
                for option in options:
                    if option.get('value') and option.get('value') != '':
                        institucion_id = option.get('value')
                        break
            
            if not solicitud_id or not institucion_id:
                self.log_result(
                    "Web Meeting Creation - Form Data",
                    False,
                    f"Could not extract form options - solicitud: {solicitud_id}, institucion: {institucion_id}"
                )
                return
            
            self.log_result(
                "Web Meeting Creation - Form Data",
                True,
                f"Form data extracted - solicitud: {solicitud_id}, institucion: {institucion_id}"
            )
            
            # Prepare meeting data
            future_date = (datetime.now() + timedelta(days=7)).strftime('%Y-%m-%d')
            meeting_data = {
                '_token': form_csrf,
                'solicitud_id': solicitud_id,
                'institucion_id': institucion_id,
                'titulo': f'Reunión de Prueba Web - {datetime.now().strftime("%Y-%m-%d %H:%M:%S")}',
                'descripcion': 'Reunión creada mediante prueba automatizada del formulario web',
                'fecha_reunion': future_date,
                'ubicacion': 'Sala de Reuniones de Prueba'
            }
            
            # Submit the form
            store_url = f"{self.base_url}/dashboard/reuniones"
            response = self.session.post(store_url, data=meeting_data, timeout=10, allow_redirects=False)
            
            if response.status_code == 302:
                location = response.headers.get('Location', '')
                if 'reuniones' in location:
                    self.log_result(
                        "Web Meeting Creation - Submit",
                        True,
                        f"Meeting created successfully, redirected to: {location}"
                    )
                    
                    # Follow redirect to verify
                    response = self.session.get(location, timeout=10)
                    if response.status_code == 200 and 'exitosamente' in response.text:
                        self.log_result(
                            "Web Meeting Creation - Verification",
                            True,
                            "Success message found on redirect page"
                        )
                    else:
                        self.log_result(
                            "Web Meeting Creation - Verification",
                            False,
                            "Success message not found on redirect page"
                        )
                else:
                    self.log_result(
                        "Web Meeting Creation - Submit",
                        False,
                        f"Unexpected redirect location: {location}"
                    )
            else:
                self.log_result(
                    "Web Meeting Creation - Submit",
                    False,
                    f"Form submission failed with status: {response.status_code}"
                )
                
        except Exception as e:
            self.log_result(
                "Web Meeting Creation",
                False,
                f"Error testing web creation: {str(e)}"
            )
    
    def test_database_integrity(self):
        """Test database integrity after operations"""
        print("\n=== Testing Database Integrity ===")
        
        try:
            # Check if meetings were created and relationships work
            integrity_code = """
            try {
                $reuniones = App\\Models\\Reunion::with(['solicitud', 'institucion'])->get();
                $count = $reuniones->count();
                
                echo "MEETINGS_COUNT:" . $count . "\\n";
                
                if ($count > 0) {
                    $reunion = $reuniones->first();
                    $hasSolicitud = $reunion->solicitud !== null;
                    $hasInstitucion = $reunion->institucion !== null;
                    
                    echo "FIRST_MEETING_SOLICITUD:" . ($hasSolicitud ? "OK" : "MISSING") . "\\n";
                    echo "FIRST_MEETING_INSTITUCION:" . ($hasInstitucion ? "OK" : "MISSING") . "\\n";
                    
                    if ($hasSolicitud) {
                        echo "SOLICITUD_ID_TYPE:" . gettype($reunion->solicitud_id) . "\\n";
                        echo "SOLICITUD_RELATIONSHIP_ID:" . $reunion->solicitud->solicitud_id . "\\n";
                    }
                }
                
                echo "INTEGRITY_CHECK:OK";
            } catch (Exception $e) {
                echo "ERROR:" . $e->getMessage();
            }
            """
            
            result = subprocess.run([
                'php', 'artisan', 'tinker', f'--execute={integrity_code}'
            ], cwd='/app', capture_output=True, text=True, timeout=30)
            
            if result.returncode == 0 and "INTEGRITY_CHECK:OK" in result.stdout:
                lines = result.stdout.strip().split('\n')
                meetings_count = 0
                
                for line in lines:
                    if line.startswith('MEETINGS_COUNT:'):
                        meetings_count = int(line.split(':', 1)[1])
                        break
                
                self.log_result(
                    "Database Integrity - Meeting Count",
                    meetings_count > 0,
                    f"Found {meetings_count} meetings in database"
                )
                
                if meetings_count > 0:
                    solicitud_ok = "FIRST_MEETING_SOLICITUD:OK" in result.stdout
                    institucion_ok = "FIRST_MEETING_INSTITUCION:OK" in result.stdout
                    
                    self.log_result(
                        "Database Integrity - Relationships",
                        solicitud_ok and institucion_ok,
                        f"Relationships working - Solicitud: {'OK' if solicitud_ok else 'FAILED'}, Institucion: {'OK' if institucion_ok else 'FAILED'}"
                    )
                    
                    # Check solicitud_id type
                    if "SOLICITUD_ID_TYPE:string" in result.stdout:
                        self.log_result(
                            "Database Integrity - Solicitud ID Type",
                            True,
                            "solicitud_id is correctly stored as string"
                        )
                    else:
                        self.log_result(
                            "Database Integrity - Solicitud ID Type",
                            False,
                            "solicitud_id type issue detected"
                        )
            else:
                self.log_result(
                    "Database Integrity Check",
                    False,
                    "Integrity check failed",
                    {'stdout': result.stdout, 'stderr': result.stderr}
                )
                
        except Exception as e:
            self.log_result(
                "Database Integrity Test",
                False,
                f"Error checking integrity: {str(e)}"
            )
    
    def run_comprehensive_tests(self):
        """Run all comprehensive tests"""
        print("🚀 Starting Comprehensive Laravel Meeting System Tests")
        print("=" * 70)
        
        # Run authentication first
        if self.authenticate():
            self.test_meeting_pages_authenticated()
            self.test_meeting_creation_via_web()
        
        self.test_database_integrity()
        
        # Summary
        print("\n" + "=" * 70)
        print("📊 COMPREHENSIVE TEST SUMMARY")
        print("=" * 70)
        
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
        with open('/app/comprehensive_test_results.json', 'w') as f:
            json.dump(self.test_results, f, indent=2, default=str)
        
        print(f"\n📄 Detailed results saved to: /app/comprehensive_test_results.json")
        
        return failed_tests == 0

if __name__ == "__main__":
    tester = ComprehensiveMeetingTester()
    success = tester.run_comprehensive_tests()
    sys.exit(0 if success else 1)