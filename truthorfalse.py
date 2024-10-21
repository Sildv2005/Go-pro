import tkinter as tk
from tkinter import messagebox
import random

# Functie om het spelvenster te openen
def open_game_window():
    # Nieuw venster voor het spel
    game_window = tk.Toplevel(root)
    game_window.title("True or False - Spel")
    game_window.geometry("400x300")

    # Stellingen en juiste antwoorden
    statements = [
        ("Gas is niet iets wat je hoeft te besparen.", False),
        ("Het is slim om veel water te gebruiken.", False),
        ("Door maaltijden voor de hele week voor te bereiden, kun je geld besparen op boodschappen", True),
        ("Water besparen door korter te douchen kan je energierekening verlagen", True),
        ("Investeren in zonnepanelen is een dure investering die geen geld bespaart op de lange termijn", False),
        ("Het is goedkoper om elke dag uit eten te gaan dan tuis te koken", False)
    ]

    # Willekeurig een stelling kiezen
    question, correct_answer = random.choice(statements)

    # Vraag label
    question_label = tk.Label(game_window, text=question, font=("Sans", 14), wraplength=350)
    question_label.pack(pady=40)

    # Functie om het antwoord te controleren
    def check_answer(is_true):
        if is_true == correct_answer:
            messagebox.showinfo("Correct!", "Goed gedaan, dat is juist!")
        else:
            messagebox.showerror("Fout!", "Sorry, dat is onjuist. (noob)")
    
    # Knoppen voor True en False
    true_button = tk.Button(game_window, text="True", font=("Arial", 14), width=10, command=lambda: check_answer(True))
    true_button.pack(side="left", padx=20, pady=20)

    false_button = tk.Button(game_window, text="False", font=("Arial", 14), width=10, command=lambda: check_answer(False))
    false_button.pack(side="right", padx=20, pady=20)

# Hoofdvenster maken
root = tk.Tk()
root.title("Truth or False - Welkom")
root.geometry("400x300")

# Welkomsttekst bovenaan
welcome_label = tk.Label(root, text="Welkom bij True or False!", font=("Sans", 20))
welcome_label.pack(pady=40)

# Knop in het midden om naar het spel te gaan
start_game_button = tk.Button(root, text="Start Spel", font=("Arial", 14), command=open_game_window)
start_game_button.pack(pady=20)

# Hoofdvenster draaien
root.mainloop()
