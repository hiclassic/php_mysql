CREATE OR REPLACE VIEW ExpensiveProducts AS
SELECT * FROM Product WHERE price > 5000;
