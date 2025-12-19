SET search_path TO lbaw2582;

-----------------------------------------
-- LEVEL 0: Independent Tables (Location, Category, Skill)
-----------------------------------------

-- R03: CATEGORY (name is UK NN, using predefined ENUM category_name) [2]

INSERT INTO category (name) VALUES
('Coding'),
('Design'),
('Marketing'),
('Finance'),
('Education'),
('Healthcare'),
('Engineering'),
('HumanResources'),
('Law'),
('Management'),
('Construction'),
('Science'),
('Other');


-- R09: SKILL (description is NN, name is UK NN, using predefined ENUM skill_name) [3, 4]

INSERT INTO skill (name, description) VALUES
('Communication', 'Ability to convey ideas clearly and effectively.'),
('Teamwork', 'Ability to collaborate well with others.'),
('ProblemSolving', 'Capacity to identify issues and find effective solutions.'),
('CriticalThinking', 'Ability to analyze situations and make reasoned decisions.'),
('Creativity', 'Ability to generate innovative and original ideas.'),
('Adaptability', 'Capacity to adjust to changing conditions or environments.'),
('Leadership', 'Ability to motivate, guide, and manage others.'),
('TimeManagement', 'Skill in prioritizing tasks and managing time effectively.'),
('AttentionToDetail', 'Ability to work with accuracy and precision.'),
('Negotiation', 'Ability to mediate and reach beneficial agreements.'),
('ProjectManagement', 'Capability to plan, organize, and oversee projects.'),
('Research', 'Skill in gathering, analyzing, and interpreting information.'),
('AnalyticalThinking', 'Ability to evaluate data, patterns, and trends.'),
('CustomerService', 'Ability to assist customers efficiently and professionally.'),
('Other', 'Skill that does not fit into predefined categories.');



INSERT INTO users (name, email, password, role, phone_number, description, location) VALUES       
('Platform Admin','admin2@konnekt.app','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','Admin','910000001',NULL,'Porto'),   
('AlphaSoft Ltd','alpha@company.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','Employer','921000001',NULL,'Lisboa'),
('Beta Marketing','beta@marketing.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','Employer','921000002',NULL,'Porto'),
('Gamma Design Studio','gamma@design.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','Employer','921000003',NULL,'Faro'),
('Remote Works Inc','remote@works.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','Employer','921000004',NULL,NULL),
('Delta Solutions','delta@solutions.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','Employer','921000005',NULL,'Braga'),

('Alice Jobseeker','alice.seeker@example.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','JobSeeker','932000001','Full-stack developer with 5 years of experience.','Porto'),
('Bob Candidate','bob.candidate@example.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','JobSeeker','932000002','Front-end developer, React specialist.','Lisboa'),
('Catarina Hunter','catarina.h@example.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','JobSeeker','932000003','Marketing professional, SEO and analytics.','Coimbra'),
('David Applicant','david.app@example.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','JobSeeker','932000004','UX/UI designer with mobile-first focus.','Faro'),
('Eva Seeker','eva.seeker@example.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','JobSeeker','932000005','Data analyst skilled in SQL and Python.','Braga'),
('Frank Hunter','frank.h@example.com','$2y$12$.4RtSVi/mvffMdS6zL79BeLniEfZkHUdF3PfaN0c6CZH6c9uQkMkG','JobSeeker','932000006','Project manager with PMP certification.','Lisboa');

-- ---------------------------
-- CVs (for jobseekers)
-- ---------------------------
INSERT INTO cv (jobseeker_id, uploaded_at, file_path, mime_type)
VALUES
(7, now(), NULL, NULL),
(8, now(), NULL, NULL),
(9, now(), NULL, NULL),
(10, now(), NULL, NULL),
(11, now(), NULL, NULL),
(12, now(), NULL, NULL);

-- ---------------------------
-- JOBPOSTS (12 total) -- ensure location logic respected
-- ---------------------------
-- Employer IDs (based on insertion order): 2..6 are employers above
INSERT INTO jobpost (employer_id, category_id, location, title, salary, work_model, contract_type, description) VALUES
(2, 1, 'Lisboa', 'Senior Backend Engineer', 90000.00, 'On-site','Internship', 'Work on scalable APIs and microservices.'),
(2, 2, NULL, 'Remote Content Marketer', 45000.00, 'Remote','Internship', 'Create content strategies for SaaS products.'),
(3, 3, 'Porto', 'UI/UX Designer (Hybrid)', 48000.00, 'Hybrid', 'Internship','Design interfaces for web and mobile.'),
(3, 2, NULL, 'SEO Specialist (Remote)', 42000.00, 'Remote', 'Internship','Optimize organic traffic and search rankings.'),
(4, 3, 'Faro', 'Senior Product Designer', 70000.00, 'On-site', 'Full-time','Design product experiences and lead design sprints.'),
(4, 1, 'Faro', 'Front-end Developer (On-site)', 52000.00, 'On-site','Full-time', 'React/TypeScript development for client projects.'),
(5, 1, NULL, 'DevOps Engineer (Remote)', 75000.00, 'Remote', 'Full-time','Infrastructure as code and CI/CD pipelines.'),
(5, 7, 'Lisboa', 'Civil Engineer (On-site)', 65000.00, 'On-site', 'Full-time','Site engineering and project management.'),
(6, 4, 'Braga', 'Financial Analyst (Hybrid)', 58000.00, 'Hybrid', 'Full-time','Financial modelling and reporting.'),
(6, 1, 'Braga', 'Junior Backend Developer', 30000.00, 'On-site', 'Full-time','Assist in backend services and APIs.'),
(2, 12, NULL, 'Research Scientist (Remote)', 68000.00, 'Remote','Part-time', 'Research projects with data-driven focus.'),
(3, 5, 'Porto', 'Education Program Manager', 47000.00, 'On-site', 'Part-time','Manage educational programs and partnerships.');

-- ---------------------------
-- JOBPOST_CATEGORY links (secondary categories)
-- ---------------------------
INSERT INTO jobpost_category (category_id, jobpost_id) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 3),
(3, 4),
(1, 6),
(1, 7),
(7, 8),
(4, 9),
(1, 10),
(12, 11),
(5, 12);

-- ---------------------------
-- SKILL_USER links (jobseekers to skills)
-- (skill IDs correspond to your skill inserts order: 1..15)
-- ---------------------------
INSERT INTO skill_user (user_id, skill_id) VALUES
(7, 1),  -- Alice: Communication
(7, 11), -- Alice: ProjectManagement
(8, 2),  -- Bob: Teamwork
(8, 6),  -- Bob: Adaptability
(9, 12), -- Catarina: Research
(9, 14), -- Catarina: CustomerService
(10, 5), -- David: Creativity
(10, 9), -- David: AttentionToDetail
(11, 13), -- Eva: AnalyticalThinking
(11, 1),  -- Eva: Communication
(12, 7);  -- Frank: Leadership

-- ---------------------------
-- APPLICATIONS (some jobseekers apply to jobposts)
-- (no duplicates; triggers will fire notify_employer_on_new_application)
-- ---------------------------
-- jobpost IDs are 1..12 in insertion order above
INSERT INTO application (jobseeker_id, jobpost_id, motivation) VALUES
(7, 1, 'I have 5 years building APIs and microservices.'),
(8, 3, 'Strong UI skills and React experience.'),
(9, 4, 'SEO background with measurable results.'),
(10, 6, 'Experienced front-end designer for mobile.'),
(11, 11, 'Research background in data-driven projects.'),
(12, 9, 'Experience in finance projects and reporting.');


INSERT INTO favourite_job (jobseeker_id, jobpost_id) VALUES
(7, 1),  -- Alice likes Senior Backend Engineer
(7, 7),  -- Alice also likes DevOps (Remote)

(8, 3),  -- Bob likes UX Designer (Hybrid)
(8, 6),  -- Bob also likes Front-end Developer

(9, 4),  -- Catarina likes SEO Specialist
(9, 12), -- And Education Program Manager

(10, 3), -- David likes UI/UX Designer
(10, 5), -- And Senior Product Designer

(11, 11), -- Eva likes Research Scientist
(11, 9),  -- Eva also likes Financial Analyst

(12, 8),  -- Frank likes Civil Engineer
(12, 1);  -- And Senior Backend Engineer


INSERT INTO skill_category (skill_id, category_id) VALUES
-- Coding
(3, 1),  -- ProblemSolving
(4, 1),  -- CriticalThinking
(13, 1), -- AnalyticalThinking
(9, 1),  -- AttentionToDetail

-- Design
(5, 2),  -- Creativity
(4, 2),  -- CriticalThinking
(1, 2),  -- Communication

-- Marketing
(1, 3),  -- Communication
(5, 3),  -- Creativity
(10, 3), -- Negotiation
(14, 3), -- CustomerService

-- Finance
(4, 4),  -- CriticalThinking
(13, 4), -- AnalyticalThinking
(9, 4),  -- AttentionToDetail

-- Education
(1, 5),  -- Communication
(12, 5), -- Research
(2, 5),  -- Teamwork

-- Healthcare
(1, 6),  -- Communication
(9, 6),  -- AttentionToDetail
(6, 6),  -- Adaptability

-- Engineering
(3, 7),  -- ProblemSolving
(13, 7), -- AnalyticalThinking
(2, 7),  -- Teamwork

-- Human Resources
(1, 8),  -- Communication
(10, 8), -- Negotiation
(7, 8),  -- Leadership

-- Law
(4, 9),  -- CriticalThinking
(1, 9),  -- Communication
(9, 9),  -- AttentionToDetail

-- Management
(7, 10), -- Leadership
(11,10), -- ProjectManagement
(8, 10), -- TimeManagement

-- Construction
(2, 11), -- Teamwork
(9, 11), -- AttentionToDetail

-- Science
(12,12), -- Research
(13,12), -- AnalyticalThinking
(4, 12), -- CriticalThinking

-- Other
(15,13); -- Other
