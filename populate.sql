SET search_path TO lbaw2582;

-----------------------------------------
-- LEVEL 0: Independent Tables (Location, Category, Skill)
-----------------------------------------

-- R02: LOCATION (country, province, city, address, postal_code are NN) [1]

INSERT INTO location (country, province, city, address, postal_code) VALUES
('Portugal', 'Porto', 'Porto', 'Rua da Tecnologia 10', '4000-001'), -- ID 1 (Porto)
('Portugal', 'Lisboa', 'Lisboa', 'Avenida Central 50', '1000-001'), -- ID 2 (Lisboa)
('Portugal', 'Faro', 'Algarve', 'Praia da Rocha', '8500-001');      -- ID 3 (Faro)


-- R03: CATEGORY (name is UK NN, using predefined ENUM category_name) [2]

INSERT INTO category (name) VALUES
('Coding'),    -- ID 1
('Marketing'), -- ID 2
('Design');    -- ID 3


-- R09: SKILL (description is NN, name is UK NN, using predefined ENUM skill_name) [3, 4]

INSERT INTO skill (name, description) VALUES
('Python', 'Expert level programming skill.'),           -- ID 1
('Social Media', 'Proficiency in social platform management.'), -- ID 2
('Communication', 'Excellent verbal and written communication.'), -- ID 3
('Problem Solving', 'Ability to resolve complex issues.');    -- ID 4


-----------------------------------------
-- LEVEL 1: Dependent on Location (Users)
-----------------------------------------

-- R01: USERS (name, email, password, role, phone_number are NN) [1, 2]
-- Note: location_id is optional (nullable) [1].

INSERT INTO users (name, email, password, role, phone_number, description, location_id) VALUES
(
    'Admin Konnekt',
    'admin@konnekt.app',
    '$2y$12$2oCUXP1L6UvXDD9BzMjpQ.wxPGDsMZz1.U/nx8NLtrHil0MQfKWe2',
    'Admin',
    '910000000',
    NULL,
    1 -- Location: Porto (ID 1)
), -- User ID 1 (Admin)
(
    'Global Tech Solutions',
    'employer_tech@global.com',
    '$2y$12$6rs74q8ujRlPKuaHT6ABp.Hm6lS1oeqtcw3hbnJXiRslUTtwNXBjm',
    'Employer',
    '921111111',
    NULL,
    2 -- Location: Lisboa (ID 2)
), -- User ID 2 (Employer)
(
    'Jane Seeker',
    'jane.seeker@email.com',
    '$2y$12$Oy5gpTqN42CRGFveMh7jZOiuwgQOTEOJE7liITSCgyXSq7MgWON.i',
    'JobSeeker',
    '932222222',
    'Experienced full-stack developer specializing in Python.',
    1 -- Location: Porto (ID 1)
), -- User ID 3 (JobSeeker, FTS Test Base)
(
    'Remote Developer Corp',
    'remote_emp@corp.com',
    '$2y$12$83Ev/z5M7gSJZkODU9J4N.gObXSnKOau.ldwmy3RHhn/yHWlxJFaG',
    'Employer',
    '943333333',
    NULL,
    NULL -- Employer with NULL location
); -- User ID 4 (Employer)


-----------------------------------------
-- LEVEL 2: Dependent on Users, Category, Location
-----------------------------------------

-- R08: CV (jobseeker_id is UK NN, description is NN) [4]

INSERT INTO cv (jobseeker_id) VALUES
(
    3 -- Jane Seeker (U3)
); -- CV ID 1


-- R04: JOBPOST (employer_id, category_id, title, salary, work_model, description are NN) [2, 5]
-- T6 (check_positive_salary) and T9 (check_jobpost_location_requirement) will fire here.

INSERT INTO jobpost (employer_id, category_id, location_id, title, salary, work_model, description) VALUES
(
    2, -- Global Tech Solutions (U2)
    1, -- Coding
    1, -- Location: Porto (L1)
    'Senior Python Developer',
    80000.00,
    'On-site', -- T9: Requires location, L1 provided.
    'We require a senior developer specializing in microservices using Python.'
), -- JobPost ID 1 (JP1)
(
    2, -- Global Tech Solutions (U2)
    2, -- Marketing
    NULL,
    'Digital Marketing Specialist',
    55000.00,
    'Remote', -- T9: Location NULL is mandatory.
    'Manage international marketing campaigns remotely, requiring Social Media skills.'
), -- JobPost ID 2 (JP2)
(
    4, -- Remote Developer Corp (U4)
    3, -- Design
    3, -- Location: Faro (L3)
    'Hybrid UX/UI Designer',
    45000.00,
    'Hybrid', -- T9: Requires location, L3 provided.
    'Design focused on mobile interfaces with strong Communication skills.'
); -- JobPost ID 3 (JP3)

-- Triggers T8 (notify_new_job_posting) and T11 (notify_matching_job_seekers) fired for JP1, JP2, JP3.


-----------------------------------------
-- LEVEL 3: Linker Tables & Core Interactions
-----------------------------------------

-- R10: SKILL_CV (Link CV1 to skills) [4]

INSERT INTO skill_cv (cv_id, skill_id) VALUES
(1, 1), -- CV 1 (U3) has Python (S1)
(1, 2); -- CV 1 (U3) has Social Media (S2)


-- R11: SKILL_JOBPOST (Link Job Posts to required skills) [6]

INSERT INTO skill_jobpost (jobpost_id, skill_id) VALUES
(1, 1), -- JP1 (Python Dev) requires Python (S1)
(1, 4), -- JP1 requires Problem Solving (S4)
(2, 2), -- JP2 (Marketing) requires Social Media (S2)
(3, 3); -- JP3 (Designer) requires Communication (S3)


-- R05: APPLICATION (T4 (duplicate check) and T7 (notify employer) fire here) [7]

-- A1: Jane Seeker (U3) applies to JP1 (Python Dev, Employer U2)
INSERT INTO application (jobseeker_id, jobpost_id, motivation) VALUES
(
    3, 
    1, 
    'Applying due to perfect skill match.'
); -- Application ID 1 (A1)


-- TEST T4 (Duplicate Check) - This should FAIL if executed, proving the trigger works.
/*
INSERT INTO application (jobseeker_id, jobpost_id, motivation) VALUES
(3, 1, 'Second attempt.'); -- Expects RAISE EXCEPTION
*/


-- R06: FAVOURITE_JOB [5]

INSERT INTO favourite_job (jobseeker_id, jobpost_id) VALUES
(
    3, -- Jane Seeker (U3)
    2  -- Remote Social Media Manager (JP2)
);


-- R07: SEARCH_HISTORY (T8 (limit history) fires here) [7]

-- Insert 11 rows to test T8 (limit_search_history) on user U3, ensuring only the 10 newest remain.
INSERT INTO search_history (user_id, search) VALUES
(3, 'Oldest search - SHOULD BE DELETED'), -- ID 1
(3, 'Python Porto'),                     -- ID 2
(3, 'Remote Marketing'),                 -- ID 3
(3, 'Design Hybrid'),                    -- ID 4
(3, 'SQL Developer'),                    -- ID 5
(3, 'HR Manager'),                       -- ID 6
(3, 'Latest Search 1'),                  -- ID 7
(3, 'Latest Search 2'),                  -- ID 8
(3, 'Latest Search 3'),                  -- ID 9
(3, 'Latest Search 4'),                  -- ID 10
(3, 'Newest Search - SHOULD BE KEPT');   -- ID 11 (T8 deletes ID 1)


-- R17: JOBPOST_CATEGORY (Secondary category linkage) [8]

INSERT INTO jobpost_category (category_id, jobpost_id) VALUES
(1, 1), -- JP1 is Coding
(2, 1); -- JP1 is also related to Marketing


-- R10: REPORT (Admin reporting on User U2) [9]

INSERT INTO report (reason, type, reporter_id, reported_user_id) VALUES
(
    'Spamming job titles.',
    'UserReport',
    1, -- Reporter: Admin (U1)
    2  -- Reported User: Employer (U2)
);
