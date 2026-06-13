# Pigeon Racer: Game Rules & Mechanics

This document serves as the master record for all game mechanics, processes, and rules in the Pigeon Racer simulation.

---

## 1. Core Mechanics
*   **Lofts:** Every user has a loft. XP is gained from race participation and podium finishes.
    *   **Leveling:** `XP required = Level^2 * 100`. Leveling up costs `Level * 500` coins.
*   **Pigeons:** Each pigeon has stats, a level (max 100), and aesthetic attributes.
    *   **Leveling:** Training milestone: Total stats must reach `level * 30` to advance. Leveling up rewards: `100 * level` coins.
    *   **Renaming:** You can rename your pigeons from the Pigeon Manager.
    *   **Attributes:** Speed, Endurance, Navigation, Temperament (trainable), and 7 Aesthetic sub-attributes (Eyes, Beak, Legs, Feather Quality, Pattern, Color, Purity).
    *   **Beauty Score:** Calculated as the average of the 7 aesthetic sub-attributes.
*   **Energy:**
    *   Passive recovery: Pigeons in `status: idle` recover 5% energy per hour (processed hourly).
    *   Active recovery: Instant 100% refill via "Rest" button (costs 50 coins).
*   **Activity Log:** Tracks training, breeding, selling/buying, and leveling activities. View it in the dedicated Activity Log page.

---

## 2. Lifecycle & Breeding

### Pigeon Lifecycle
1.  **Egg:** Produced after 6 hours of successful pairing. Incubation period is 1 day.
2.  **Hatchling:** Hatches from egg after 1 day incubation.
3.  **Juvenile:** Transitions 1 day after hatching.
4.  **Adult:** Achieves adulthood 4 days after hatching.
5.  **Breeding:** Only paired adult pigeons (4+ days old) can breed.

### Breeding Rules
*   **Breeding Cages:** Loft level determines the maximum number of active breeding pairs (`1 cage per level`).
*   **Inbreeding Prevention:** Parent and child can never be paired.
*   **Pairing:** Must be a male and female pair.
*   **Breeding Outcome:** Lays 2 eggs.
*   **Stats Inheritance:** Offspring stats are random between the minimum and maximum of the two parents' corresponding attributes.
*   **Lockout:** Parents in incubation/nursing status cannot participate in tournaments.

---

## 3. Tournaments & Matchmaking

### Tournament Types
*   **Exhibition:** Focuses on `Beauty Score`.
*   **Highflyer:** Focuses on `Endurance` + `Navigation`.
*   **Racing:** Focuses on `Speed` + `Endurance`.

### Matchmaking
*   AI opponents are generated with stats appropriate to their level (1-100).
*   Matchmaking selects AI opponents within a `±1` level range of the user's loft level.
*   Only Exhibition tournaments are available for loft levels < 5.

### Scoring
*   **Pigeon Total Score:** `Speed + Endurance + Navigation + Temperament + (Beauty * 2)`.
*   **Loft Score:** Sum of all pigeons' total scores in the loft.

---

## 4. Economy & Marketplace V3
*   **Coins:** Earned from tournament prizes and leveling up pigeons.
*   **Auction House:**
    *   **Time-Limited:** Every listing has a 24-hour expiry timer. Expired units are returned to their loft.
    *   **Level Constraints:** You can only view and purchase pigeons that are at most `Loft Level + 1`.
    *   **Autonomous AI:** AI lofts actively trade in the market, listing and buying units within their own level range (`±1`).
    *   **Market Cycle:** The economy processes a "Market Tick" every hour to simulate AI activity.
*   **Spending:**
    *   Entering tournaments.
    *   Training (stat boosts).
    *   Resting (energy refill).
    *   Aesthetic Upgrades (`feather_quality`, `pattern`, `color`).
*   **Aesthetic Upgrades:** Exponential cost (`50 * 1.15^level`), fractional growth (`0.5 - 1.0` points).

---

## 5. Admin Controls
*   Admin can trigger the hourly maturation (hatching, growth, auction cleanup) and market ticks manually via the Admin Dashboard.
