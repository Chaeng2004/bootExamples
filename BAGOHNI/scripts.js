// scripts.js

document.addEventListener('DOMContentLoaded', () => {
  // Elements for index.html
  const searchForm = document.getElementById('search-form');
  const searchResults = document.getElementById('search-results');

  // Elements for bus-details.html
  const busDetailsDiv = document.getElementById('bus-details');
  const bookNowBtn = document.getElementById('book-now-btn');

  // Utility to get query params
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  // ----------------- index.html logic -----------------
  if (searchForm) {
    searchForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const location = e.target.location.value.trim();
      const destination = e.target.destination.value.trim();
      const date = e.target.date.value;

      if (!location || !destination || !date) {
        alert('Please fill all search fields.');
        return;
      }

      try {
        const response = await fetch('search_buses.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ location, destination, date }),
        });
        const data = await response.json();
        if (data.success) {
          displaySearchResults(data.buses);
        } else {
          searchResults.innerHTML = '<p>No buses found.</p>';
        }
      } catch (error) {
        console.error(error);
        searchResults.innerHTML = '<p>Error searching buses.</p>';
      }
    });

    function displaySearchResults(buses) {
      if (!buses.length) {
        searchResults.innerHTML = '<p>No buses found.</p>';
        return;
      }
      searchResults.innerHTML = '';
      buses.forEach((bus) => {
        const div = document.createElement('div');
        div.className = 'bus-item';
        div.textContent = `Bus ${bus.bus_number} - ${bus.location} to ${bus.destination} - ${bus.bus_type} - Date: ${bus.date} - Departure Time: ${bus.departure_time} - Arrival Time: ${bus.arrival_time} - Seats: ${bus.available_seats} - Price: PHP${bus.price}`;
        div.addEventListener('click', () => {
          window.location.href = `bus_details.php?bus_id=${bus.bus_id}`;
        });
        searchResults.appendChild(div);
      });
    }
  }

  // ----------------- bus-details.html logic -----------------
  if (busDetailsDiv && bookNowBtn) {
    const busId = getQueryParam('bus_id');
    if (!busId) {
      busDetailsDiv.innerHTML = '<p>Bus ID not specified.</p>';
    } else {
      fetchBusDetails(busId);
    }

   async function fetchBusDetails(busId) {
  try {
    const response = await fetch(`get_bus_details.php?bus_id=${busId}`);
    const data = await response.json();
    console.log(data); // Add this line for debugging
    if (data.success && data.bus) {
      displayBusDetails(data.bus);
    } else {
      busDetailsDiv.innerHTML = '<p>Bus not found or invalid bus ID.</p>';
    }
  } catch (error) {
    console.error(error);
    busDetailsDiv.innerHTML = '<p>Error fetching bus details.</p>';
  }
}

    function displayBusDetails(bus) {
      if (!bus) {
        busDetailsDiv.innerHTML = '<p>Invalid bus data.</p>';
        return;
      }

      busDetailsDiv.innerHTML = `
        <p><strong>Bus Number:</strong> ${bus.bus_number || 'N/A'}</p>
        <p><strong>Location:</strong> ${bus.location || 'N/A'}</p>
        <p><strong>Destination:</strong> ${bus.destination || 'N/A'}</p>
        <p><strong>Bus Type:</strong> ${bus.bus_type || 'N/A'}</p>
        <p><strong>Date:</strong> ${bus.date || 'N/A'}</p>
        <p><strong>Departure Time:</strong> ${bus.departure_time || 'N/A'}</p>
        <p><strong>Arrival Time:</strong> ${bus.arrival_time || 'N/A'}</p>
        <p><strong>Available Seats:</strong> ${bus.available_seats || 'N/A'}</p>
        <p><strong>Price:</strong> PHP${bus.price || '0'}</p>
      `;
      

      bookNowBtn.onclick = () => {
      window.location.href = `ticket_form.php?bus_id=${bus.bus_id}`;
};

    }
  }

});
