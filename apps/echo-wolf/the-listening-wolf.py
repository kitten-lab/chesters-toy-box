import sqlite3
import random

def initialize_db():
    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("""
        CREATE TABLE IF NOT EXISTS messages (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	content TEXT
        )
    """)

    conn.commit()
    conn.close()

def save_message(text):
    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("INSERT INTO messages (content) VALUES (?)", (text,))

    conn.commit()
    conn.close()

def count_messages():
    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("SELECT COUNT(*) FROM messages")
    count = cursor.fetchone()[0]

    conn.close()
    return count

def print_messages():

    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("SELECT TEXT FROM messages (content)")
    count = cursor.fetchone()[0]

    conn.close()
    return random.choice(count)


write_actions = [
    "The wolf writes it down.",
    "The wolf scratches the words into the log.",
    "The wolf tilts his head and records it.",
    "The wolf listens carefully and stores the memory.",
    "The wolf nods slowly and writes."
]

def run():
    print("The wires hum. The wolf leans forward.")

    initialize_db()

    while True:
        user_input = input("You: ")

        if user_input.lower() == "end":
            print("The wolf dissolves back into the wires.")
            break

        if user_input.lower() == "help":
            print("Only you can help yourself.")
        

        if user_input.lower() == "$echo":
            print_messages();


        save_message(user_input)

        total = count_messages()

        print(random.choice(write_actions) + f"\n'{user_input}' is recorded to the memory.")
        print(f"(Persistent memory size: {total})")

if __name__ == "__main__":
    run()
