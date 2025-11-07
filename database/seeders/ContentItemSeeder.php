<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContentItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentData = [
            'quantum' => [
                [
                    'title' => 'Quantum Computing in Automotive',
                    'description' => 'Exploring quantum computing applications for vehicle optimization and route planning.',
                    'category' => 'Research',
                    'date' => '2025-01-10',
                    'objective_list' => ['Quantum algorithms', 'Optimization research', 'Performance analysis'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Sensors for Vehicles',
                    'description' => 'Advanced quantum sensor technology for enhanced vehicle perception systems.',
                    'category' => 'Sensors',
                    'date' => '2025-01-18',
                    'objective_list' => ['Sensor development', 'Integration testing', 'Calibration systems'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Cryptography',
                    'description' => 'Quantum key distribution for ultra-secure vehicle communications.',
                    'category' => 'Security',
                    'date' => '2025-02-05',
                    'objective_list' => ['QKD implementation', 'Network security', 'Key management'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Quantum Machine Learning',
                    'description' => 'Quantum-enhanced machine learning for autonomous vehicle decision making.',
                    'category' => 'AI/ML',
                    'date' => '2025-02-12',
                    'objective_list' => ['Algorithm development', 'Model training', 'Performance evaluation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Simulation',
                    'description' => 'Quantum simulation for material science in battery and component development.',
                    'category' => 'Simulation',
                    'date' => '2025-02-20',
                    'objective_list' => ['Material modeling', 'Simulation framework', 'Analysis tools'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Networking',
                    'description' => 'Quantum networking protocols for vehicle-to-vehicle communication.',
                    'category' => 'Networking',
                    'date' => '2025-03-01',
                    'objective_list' => ['Protocol design', 'Network architecture', 'Interoperability'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Quantum Error Correction',
                    'description' => 'Error correction techniques for quantum computing in automotive applications.',
                    'category' => 'Research',
                    'date' => '2025-03-08',
                    'objective_list' => ['Error models', 'Correction algorithms', 'Validation methods'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Optimization',
                    'description' => 'Quantum optimization algorithms for traffic flow and logistics.',
                    'category' => 'Optimization',
                    'date' => '2025-03-15',
                    'objective_list' => ['Algorithm design', 'Benchmarking', 'Real-world testing'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum AI Integration',
                    'description' => 'Integrating quantum AI capabilities into vehicle control systems.',
                    'category' => 'Integration',
                    'date' => '2025-03-22',
                    'objective_list' => ['System integration', 'API development', 'Testing framework'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Quantum Hardware',
                    'description' => 'Quantum hardware requirements and specifications for automotive use cases.',
                    'category' => 'Hardware',
                    'date' => '2025-03-30',
                    'objective_list' => ['Hardware selection', 'Specification design', 'Integration planning'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Software Stack',
                    'description' => 'Complete quantum software stack for automotive quantum computing applications.',
                    'category' => 'Software',
                    'date' => '2025-04-05',
                    'objective_list' => ['Stack architecture', 'Middleware development', 'Application layer'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Standards',
                    'description' => 'Developing standards and protocols for quantum computing in automotive.',
                    'category' => 'Standards',
                    'date' => '2025-04-12',
                    'objective_list' => ['Standard definition', 'Protocol specification', 'Compliance framework'],
                    'status' => 'waiting',
                ],
            ],
            'services' => [
                [
                    'title' => 'Cybersecurity Management Systems',
                    'description' => 'End-to-end cybersecurity solutions for vehicle platforms with threat detection and response.',
                    'category' => 'Security',
                    'date' => '2025-01-12',
                    'objective_list' => ['ISO 21434 compliance', 'Threat modeling', 'Security testing'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Functional Safety Consulting',
                    'description' => 'Expert consulting for ISO 26262 functional safety implementation.',
                    'category' => 'Safety',
                    'date' => '2025-01-25',
                    'objective_list' => ['Safety analysis', 'Hazard identification', 'Risk assessment'],
                    'status' => 'active',
                ],
                [
                    'title' => 'OTA Update Services',
                    'description' => 'Complete over-the-air update management and deployment services.',
                    'category' => 'Updates',
                    'date' => '2025-02-08',
                    'objective_list' => ['Update deployment', 'Version management', 'Rollback support'],
                    'status' => 'active',
                ],
                [
                    'title' => 'ASPICE Assessment',
                    'description' => 'Automotive SPICE process assessment and improvement services.',
                    'category' => 'Process',
                    'date' => '2025-02-18',
                    'objective_list' => ['Process evaluation', 'Gap analysis', 'Improvement roadmap'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'AUTOSAR Implementation',
                    'description' => 'Full AUTOSAR stack implementation and configuration services.',
                    'category' => 'Architecture',
                    'date' => '2025-02-28',
                    'objective_list' => ['ECU configuration', 'BSW setup', 'Application integration'],
                    'status' => 'active',
                ],
                [
                    'title' => 'E/E Architecture Design',
                    'description' => 'Electrical and Electronic architecture design and optimization.',
                    'category' => 'Architecture',
                    'date' => '2025-03-05',
                    'objective_list' => ['Architecture design', 'Component selection', 'Integration planning'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Software Testing Services',
                    'description' => 'Comprehensive software testing and validation services.',
                    'category' => 'Testing',
                    'date' => '2025-03-12',
                    'objective_list' => ['Test planning', 'Test execution', 'Report generation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Training & Certification',
                    'description' => 'Professional training programs and certification services.',
                    'category' => 'Education',
                    'date' => '2025-03-20',
                    'objective_list' => ['Course development', 'Training delivery', 'Certification exams'],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV Platform Development',
                    'description' => 'Software Defined Vehicle platform development and integration.',
                    'category' => 'Platform',
                    'date' => '2025-03-28',
                    'objective_list' => ['Platform architecture', 'Middleware development', 'API design'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Cloud Services Integration',
                    'description' => 'Cloud-based services integration for connected vehicles.',
                    'category' => 'Cloud',
                    'date' => '2025-04-05',
                    'objective_list' => ['Cloud connectivity', 'Data pipeline', 'Service integration'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Compliance & Certification',
                    'description' => 'Regulatory compliance and certification support services.',
                    'category' => 'Compliance',
                    'date' => '2025-04-12',
                    'objective_list' => ['Compliance audit', 'Documentation', 'Certification support'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Legacy System Support',
                    'description' => 'Support and migration services for legacy automotive systems.',
                    'category' => 'Support',
                    'date' => '2025-04-20',
                    'objective_list' => ['System maintenance', 'Migration planning', 'Support services'],
                    'status' => 'waiting',
                ],
            ],
            'products' => [
                [
                    'title' => 'Secure Gateway Platform',
                    'description' => 'Hardware security module for vehicle gateway with encryption and key management.',
                    'category' => 'Hardware',
                    'date' => '2025-01-14',
                    'objective_list' => ['Hardware design', 'Security implementation', 'Certification'],
                    'status' => 'active',
                ],
                [
                    'title' => 'OTA Update Manager',
                    'description' => 'Software platform for managing over-the-air updates across vehicle fleets.',
                    'category' => 'Software',
                    'date' => '2025-01-22',
                    'objective_list' => ['Platform development', 'Deployment tools', 'Monitoring dashboard'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Safety Analysis Tool',
                    'description' => 'Automated tool for functional safety analysis and documentation.',
                    'category' => 'Software',
                    'date' => '2025-02-03',
                    'objective_list' => ['Tool development', 'Analysis algorithms', 'Report generation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'AUTOSAR Configuration Tool',
                    'description' => 'Graphical tool for AUTOSAR ECU configuration and code generation.',
                    'category' => 'Software',
                    'date' => '2025-02-14',
                    'objective_list' => ['UI development', 'Configuration engine', 'Code generator'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Cybersecurity Monitor',
                    'description' => 'Real-time cybersecurity monitoring and threat detection system.',
                    'category' => 'Software',
                    'date' => '2025-02-25',
                    'objective_list' => ['Monitoring engine', 'Threat detection', 'Alert system'],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV Middleware',
                    'description' => 'Middleware platform for Software Defined Vehicle applications.',
                    'category' => 'Platform',
                    'date' => '2025-03-07',
                    'objective_list' => ['Middleware core', 'API framework', 'Service layer'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Test Automation Framework',
                    'description' => 'Comprehensive test automation framework for automotive software.',
                    'category' => 'Testing',
                    'date' => '2025-03-18',
                    'objective_list' => ['Framework design', 'Test execution engine', 'Reporting system'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Cloud Analytics Platform',
                    'description' => 'Cloud-based analytics platform for vehicle data processing.',
                    'category' => 'Cloud',
                    'date' => '2025-03-25',
                    'objective_list' => ['Data pipeline', 'Analytics engine', 'Visualization tools'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Compliance Manager',
                    'description' => 'Tool for managing regulatory compliance and documentation.',
                    'category' => 'Software',
                    'date' => '2025-04-02',
                    'objective_list' => ['Compliance tracking', 'Document management', 'Audit trails'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle Simulator',
                    'description' => 'High-fidelity vehicle simulator for software testing and validation.',
                    'category' => 'Simulation',
                    'date' => '2025-04-10',
                    'objective_list' => ['Simulator engine', 'Vehicle models', 'Test scenarios'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Diagnostic Tool',
                    'description' => 'Advanced diagnostic tool for vehicle system troubleshooting.',
                    'category' => 'Tools',
                    'date' => '2025-04-18',
                    'objective_list' => ['Diagnostic engine', 'Data analysis', 'Report generation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'API Gateway',
                    'description' => 'API gateway for vehicle service integration and management.',
                    'category' => 'Platform',
                    'date' => '2025-04-25',
                    'objective_list' => ['Gateway core', 'API management', 'Security layer'],
                    'status' => 'waiting',
                ],
            ],
            'training' => [
                [
                    'title' => 'ISO 26262 Functional Safety',
                    'description' => 'Comprehensive training on ISO 26262 functional safety standards and implementation.',
                    'category' => 'Safety',
                    'date' => '2025-01-16',
                    'objective_list' => ['Standard overview', 'Hazard analysis', 'Safety case development'],
                    'status' => 'active',
                ],
                [
                    'title' => 'ISO 21434 Cybersecurity',
                    'description' => 'Training program on ISO 21434 cybersecurity management for vehicles.',
                    'category' => 'Security',
                    'date' => '2025-01-24',
                    'objective_list' => ['Threat analysis', 'Risk assessment', 'Security testing'],
                    'status' => 'active',
                ],
                [
                    'title' => 'AUTOSAR Fundamentals',
                    'description' => 'Introduction to AUTOSAR architecture and development practices.',
                    'category' => 'Architecture',
                    'date' => '2025-02-06',
                    'objective_list' => ['Architecture overview', 'BSW configuration', 'Application development'],
                    'status' => 'active',
                ],
                [
                    'title' => 'ASPICE Process Improvement',
                    'description' => 'Training on Automotive SPICE process assessment and improvement.',
                    'category' => 'Process',
                    'date' => '2025-02-16',
                    'objective_list' => ['Process assessment', 'Capability levels', 'Improvement strategies'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'OTA Update Management',
                    'description' => 'Training on over-the-air update deployment and management.',
                    'category' => 'Updates',
                    'date' => '2025-02-26',
                    'objective_list' => ['Update strategies', 'Deployment process', 'Rollback procedures'],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV Development',
                    'description' => 'Software Defined Vehicle development and architecture training.',
                    'category' => 'Platform',
                    'date' => '2025-03-09',
                    'objective_list' => ['SDV concepts', 'Platform architecture', 'Application development'],
                    'status' => 'active',
                ],
                [
                    'title' => 'E/E Architecture Design',
                    'description' => 'Training on Electrical and Electronic architecture design principles.',
                    'category' => 'Architecture',
                    'date' => '2025-03-19',
                    'objective_list' => ['Architecture patterns', 'Component design', 'Integration strategies'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Automotive Testing',
                    'description' => 'Comprehensive training on automotive software testing methodologies.',
                    'category' => 'Testing',
                    'date' => '2025-03-27',
                    'objective_list' => ['Test strategies', 'Test automation', 'Validation methods'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Cloud Integration',
                    'description' => 'Training on cloud services integration for connected vehicles.',
                    'category' => 'Cloud',
                    'date' => '2025-04-07',
                    'objective_list' => ['Cloud architecture', 'API integration', 'Data management'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Cybersecurity Testing',
                    'description' => 'Hands-on training on cybersecurity testing and penetration testing.',
                    'category' => 'Security',
                    'date' => '2025-04-15',
                    'objective_list' => ['Penetration testing', 'Vulnerability assessment', 'Security tools'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Compliance & Certification',
                    'description' => 'Training on regulatory compliance and certification processes.',
                    'category' => 'Compliance',
                    'date' => '2025-04-23',
                    'objective_list' => ['Regulatory requirements', 'Documentation', 'Certification process'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Advanced AUTOSAR',
                    'description' => 'Advanced AUTOSAR development and optimization techniques.',
                    'category' => 'Architecture',
                    'date' => '2025-04-30',
                    'objective_list' => ['Advanced topics', 'Optimization', 'Best practices'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Embedded Systems Security',
                    'description' => 'Comprehensive training on securing embedded systems in automotive applications.',
                    'category' => 'Security',
                    'date' => '2025-05-08',
                    'objective_list' => ['Embedded security', 'Secure boot', 'Hardware security'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle Network Security',
                    'description' => 'Training on securing vehicle communication networks and protocols.',
                    'category' => 'Security',
                    'date' => '2025-05-15',
                    'objective_list' => ['Network protocols', 'CAN security', 'Ethernet security'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Functional Safety Analysis',
                    'description' => 'Deep dive into functional safety analysis methods and techniques.',
                    'category' => 'Safety',
                    'date' => '2025-05-22',
                    'objective_list' => ['Hazard analysis', 'FMEA', 'FTA methods'],
                    'status' => 'active',
                ],
                [
                    'title' => 'SDV Cloud Architecture',
                    'description' => 'Training on cloud architecture patterns for Software Defined Vehicles.',
                    'category' => 'Cloud',
                    'date' => '2025-05-29',
                    'objective_list' => ['Cloud patterns', 'Microservices', 'Scalability'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Automotive AI/ML',
                    'description' => 'Machine learning and AI applications in automotive systems.',
                    'category' => 'AI/ML',
                    'date' => '2025-06-05',
                    'objective_list' => ['ML algorithms', 'Neural networks', 'Model deployment'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle Diagnostics',
                    'description' => 'Training on vehicle diagnostic systems and troubleshooting techniques.',
                    'category' => 'Diagnostics',
                    'date' => '2025-06-12',
                    'objective_list' => ['Diagnostic protocols', 'Troubleshooting', 'Tools usage'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Secure Coding Practices',
                    'description' => 'Secure coding practices and standards for automotive software development.',
                    'category' => 'Security',
                    'date' => '2025-06-19',
                    'objective_list' => ['Coding standards', 'Vulnerability prevention', 'Code review'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle Data Management',
                    'description' => 'Training on managing and processing vehicle data efficiently.',
                    'category' => 'Data',
                    'date' => '2025-06-26',
                    'objective_list' => ['Data pipelines', 'Data storage', 'Analytics'],
                    'status' => 'active',
                ],
                [
                    'title' => 'CAN Bus Security',
                    'description' => 'Comprehensive training on securing CAN bus communication networks in vehicles.',
                    'category' => 'Security',
                    'date' => '2025-07-03',
                    'objective_list' => ['CAN protocols', 'Security threats', 'Protection mechanisms'],
                    'status' => 'active',
                ],
                [
                    'title' => 'ISO 14229 UDS Protocol',
                    'description' => 'Training on Unified Diagnostic Services (UDS) protocol implementation.',
                    'category' => 'Diagnostics',
                    'date' => '2025-07-10',
                    'objective_list' => ['UDS basics', 'Service implementation', 'Diagnostic tools'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Safety Integrity Levels (SIL)',
                    'description' => 'Understanding Safety Integrity Levels and their application in automotive systems.',
                    'category' => 'Safety',
                    'date' => '2025-07-17',
                    'objective_list' => ['SIL concepts', 'Risk assessment', 'Compliance'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Microservices Architecture',
                    'description' => 'Building microservices architectures for Software Defined Vehicles.',
                    'category' => 'Architecture',
                    'date' => '2025-07-24',
                    'objective_list' => ['Microservices design', 'Service communication', 'Deployment'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Threat Modeling',
                    'description' => 'Systematic approach to identifying and mitigating security threats in vehicles.',
                    'category' => 'Security',
                    'date' => '2025-07-31',
                    'objective_list' => ['Threat identification', 'Risk analysis', 'Mitigation strategies'],
                    'status' => 'active',
                ],
                [
                    'title' => 'AUTOSAR Adaptive Platform',
                    'description' => 'Training on AUTOSAR Adaptive Platform for high-performance computing ECUs.',
                    'category' => 'Architecture',
                    'date' => '2025-08-07',
                    'objective_list' => ['Adaptive platform', 'Service-oriented architecture', 'Application development'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle-to-Everything (V2X)',
                    'description' => 'Training on V2X communication technologies and implementation.',
                    'category' => 'Networking',
                    'date' => '2025-08-14',
                    'objective_list' => ['V2X protocols', 'Communication standards', 'Security aspects'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Fault Tolerance Systems',
                    'description' => 'Designing fault-tolerant systems for critical automotive applications.',
                    'category' => 'Safety',
                    'date' => '2025-08-21',
                    'objective_list' => ['Fault tolerance', 'Redundancy design', 'Error handling'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Container Orchestration',
                    'description' => 'Kubernetes and container orchestration for automotive cloud services.',
                    'category' => 'Cloud',
                    'date' => '2025-08-28',
                    'objective_list' => ['Kubernetes basics', 'Container management', 'Scaling strategies'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Penetration Testing',
                    'description' => 'Hands-on penetration testing techniques for vehicle systems.',
                    'category' => 'Security',
                    'date' => '2025-09-04',
                    'objective_list' => ['Penetration methodology', 'Tool usage', 'Reporting'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Model-Based Development',
                    'description' => 'Model-based development approaches for automotive software.',
                    'category' => 'Development',
                    'date' => '2025-09-11',
                    'objective_list' => ['Modeling tools', 'Code generation', 'Simulation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Real-Time Systems',
                    'description' => 'Design and development of real-time systems for automotive applications.',
                    'category' => 'Architecture',
                    'date' => '2025-09-18',
                    'objective_list' => ['RTOS concepts', 'Scheduling algorithms', 'Timing analysis'],
                    'status' => 'active',
                ],
                [
                    'title' => 'ISO 27001 for Automotive',
                    'description' => 'Information security management system implementation for automotive.',
                    'category' => 'Security',
                    'date' => '2025-09-25',
                    'objective_list' => ['ISO 27001 standard', 'ISMS implementation', 'Audit preparation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Edge Computing',
                    'description' => 'Edge computing architectures for connected vehicle applications.',
                    'category' => 'Architecture',
                    'date' => '2025-10-02',
                    'objective_list' => ['Edge concepts', 'Deployment strategies', 'Latency optimization'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Requirements Engineering',
                    'description' => 'Best practices for requirements engineering in automotive projects.',
                    'category' => 'Process',
                    'date' => '2025-10-09',
                    'objective_list' => ['Requirements gathering', 'Documentation', 'Traceability'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Hardware Security Modules',
                    'description' => 'Implementation and management of Hardware Security Modules (HSM) in vehicles.',
                    'category' => 'Security',
                    'date' => '2025-10-16',
                    'objective_list' => ['HSM basics', 'Key management', 'Integration'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Continuous Integration/Deployment',
                    'description' => 'CI/CD pipelines for automotive software development and deployment.',
                    'category' => 'Development',
                    'date' => '2025-10-23',
                    'objective_list' => ['CI/CD setup', 'Automated testing', 'Deployment automation'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Vehicle Hacking Defense',
                    'description' => 'Defensive strategies against vehicle hacking and cyber attacks.',
                    'category' => 'Security',
                    'date' => '2025-10-30',
                    'objective_list' => ['Attack vectors', 'Defense mechanisms', 'Incident response'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Software Architecture Patterns',
                    'description' => 'Essential software architecture patterns for automotive systems.',
                    'category' => 'Architecture',
                    'date' => '2025-11-06',
                    'objective_list' => ['Architecture patterns', 'Design principles', 'Best practices'],
                    'status' => 'active',
                ],
                [
                    'title' => 'DevOps for Automotive',
                    'description' => 'DevOps practices and tools for automotive software development lifecycle.',
                    'category' => 'Development',
                    'date' => '2025-11-13',
                    'objective_list' => ['DevOps culture', 'Automation tools', 'CI/CD pipelines'],
                    'status' => 'active',
                ],
            ],
            'blog' => [
                [
                    'title' => 'The Future of Software Defined Vehicles',
                    'description' => 'Exploring how SDV technology is transforming the automotive industry.',
                    'category' => 'Technology',
                    'date' => '2025-01-11',
                    'objective_list' => ['Industry trends', 'Technology overview', 'Future predictions'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Cybersecurity Best Practices for Vehicles',
                    'description' => 'Essential cybersecurity practices for protecting connected vehicles.',
                    'category' => 'Security',
                    'date' => '2025-01-19',
                    'objective_list' => ['Security guidelines', 'Threat mitigation', 'Best practices'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Understanding ISO 26262',
                    'description' => 'A comprehensive guide to functional safety standards in automotive.',
                    'category' => 'Standards',
                    'date' => '2025-02-02',
                    'objective_list' => ['Standard explanation', 'Implementation guide', 'Case studies'],
                    'status' => 'active',
                ],
                [
                    'title' => 'OTA Updates: Challenges and Solutions',
                    'description' => 'Addressing the challenges of over-the-air updates in vehicles.',
                    'category' => 'Technology',
                    'date' => '2025-02-11',
                    'objective_list' => ['Challenges overview', 'Solution approaches', 'Best practices'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'AUTOSAR: A Complete Guide',
                    'description' => 'Everything you need to know about AUTOSAR architecture.',
                    'category' => 'Architecture',
                    'date' => '2025-02-21',
                    'objective_list' => ['Architecture overview', 'Development guide', 'Implementation tips'],
                    'status' => 'active',
                ],
                [
                    'title' => 'E/E Architecture Evolution',
                    'description' => 'How vehicle electrical architectures are evolving with new technologies.',
                    'category' => 'Architecture',
                    'date' => '2025-03-03',
                    'objective_list' => ['Evolution trends', 'Modern architectures', 'Future directions'],
                    'status' => 'active',
                ],
                [
                    'title' => 'ASPICE: Process Improvement Guide',
                    'description' => 'How to improve your development processes with Automotive SPICE.',
                    'category' => 'Process',
                    'date' => '2025-03-13',
                    'objective_list' => ['Process improvement', 'Assessment guide', 'Success stories'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Cloud Services in Automotive',
                    'description' => 'Leveraging cloud services for connected vehicle applications.',
                    'category' => 'Cloud',
                    'date' => '2025-03-21',
                    'objective_list' => ['Cloud benefits', 'Use cases', 'Implementation guide'],
                    'status' => 'waiting',
                ],
                [
                    'title' => 'Testing Strategies for Automotive Software',
                    'description' => 'Effective testing strategies for ensuring software quality in vehicles.',
                    'category' => 'Testing',
                    'date' => '2025-03-29',
                    'objective_list' => ['Testing approaches', 'Test automation', 'Quality assurance'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Quantum Computing in Automotive',
                    'description' => 'Exploring the potential of quantum computing in vehicle systems.',
                    'category' => 'Technology',
                    'date' => '2025-04-06',
                    'objective_list' => ['Quantum applications', 'Use cases', 'Future potential'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Compliance Made Easy',
                    'description' => 'Simplifying regulatory compliance for automotive software.',
                    'category' => 'Compliance',
                    'date' => '2025-04-14',
                    'objective_list' => ['Compliance guide', 'Documentation tips', 'Certification process'],
                    'status' => 'active',
                ],
                [
                    'title' => 'Legacy System Modernization',
                    'description' => 'Strategies for modernizing legacy automotive systems.',
                    'category' => 'Migration',
                    'date' => '2025-04-22',
                    'objective_list' => ['Migration strategies', 'Modernization approaches', 'Case studies'],
                    'status' => 'waiting',
                ],
            ],
        ];

        // Load all categories into a map for faster lookup
        $categoriesMap = Category::pluck('id', 'title')->toArray();
        $missingCategories = [];
        
        // Verify all categories exist before processing
        $this->command->info('Verifying categories...');
        foreach ($contentData as $type => $items) {
            foreach ($items as $item) {
                if (!empty($item['category']) && !isset($categoriesMap[$item['category']])) {
                    if (!in_array($item['category'], $missingCategories)) {
                        $missingCategories[] = $item['category'];
                    }
                }
            }
        }
        
        if (!empty($missingCategories)) {
            $this->command->error('Missing categories in CategorySeeder: ' . implode(', ', $missingCategories));
            $this->command->error('Please add these categories to CategorySeeder before continuing.');
            return;
        }
        
        $this->command->info('All categories verified. Proceeding with content item creation...');
        
        foreach ($contentData as $type => $items) {
            foreach ($items as $index => $item) {
                // Find category by title if provided
                $categoryId = null;
                if (!empty($item['category'])) {
                    if (isset($categoriesMap[$item['category']])) {
                        $categoryId = $categoriesMap[$item['category']];
                    } else {
                        // This should not happen if verification passed, but handle it anyway
                        $this->command->warn("Category '{$item['category']}' not found for item: {$item['title']}");
                    }
                }
                
                // Check if item already exists (by type and title) to prevent duplicates
                $existingItem = ContentItem::where('type', $type)
                    ->where('title', $item['title'])
                    ->first();
                
                if ($existingItem) {
                    $this->command->info("Skipping duplicate: {$item['title']} (already exists)");
                    continue;
                }
                
                // Generate unique slug
                $baseSlug = \Illuminate\Support\Str::slug($item['title']);
                $slug = $baseSlug;
                $counter = 1;
                while (ContentItem::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                // Prepare base data
                $itemData = [
                    'type' => $type,
                    'title' => $item['title'],
                    'slug' => $slug,
                    'description' => $item['description'],
                    'category_id' => $categoryId,
                    'date' => Carbon::parse($item['date']),
                    'objective_list' => $item['objective_list'],
                    'status' => $item['status'],
                    'order' => $index,
                    'created_at' => Carbon::parse($item['date']),
                    'updated_at' => Carbon::parse($item['date']),
                ];

                // Add training-specific fields if type is training
                if ($type === 'training') {
                    $itemData['is_enrollable'] = $item['status'] === 'active';
                    $itemData['price'] = $item['price'] ?? rand(500, 2000);
                    $itemData['currency'] = $item['currency'] ?? 'USD';
                    $itemData['duration_days'] = $item['duration_days'] ?? rand(3, 10);
                    $itemData['start_date'] = Carbon::parse($item['date'])->addDays(rand(30, 90));
                    $itemData['max_students'] = $item['max_students'] ?? rand(20, 50);
                }

                ContentItem::create($itemData);
            }
        }

        $totalItems = array_sum(array_map('count', $contentData));
        $this->command->info('Content items seeded successfully!');
        $this->command->info("Total items created: {$totalItems}");
        
        if (!empty($missingCategories)) {
            $this->command->warn('Missing categories that need to be added: ' . implode(', ', $missingCategories));
        }
        
        // Report category assignment statistics
        $itemsWithCategories = ContentItem::whereNotNull('category_id')->count();
        $this->command->info("Items with categories assigned: {$itemsWithCategories} / {$totalItems}");
    }
}
