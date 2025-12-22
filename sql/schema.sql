-- Courses table
CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

-- Quizzes table (directly linked to courses)
CREATE TABLE quizzes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  title VARCHAR(100) NOT NULL,
  description TEXT,
  FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Questions table (linked to quizzes)
CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  quiz_id INT NOT NULL,
  question_text TEXT NOT NULL,
  option_a VARCHAR(255),
  option_b VARCHAR(255),
  option_c VARCHAR(255),
  correct_answer CHAR(1),
  FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);

-- Admins table (for login)
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255) NOT NULL
);
