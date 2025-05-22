<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DOM elements
        const assetTypeSelect = document.getElementById('assetType');
        const searchInput = document.getElementById('searchAsset');
        const sortBySelect = document.getElementById('sortBy');
        const assetsTableBody = document.getElementById('assetsTableBody');
        const loadingRow = document.getElementById('loadingRow');
        const errorRow = document.getElementById('errorRow');
        const emptyRow = document.getElementById('emptyRow');
        const lastUpdatedEl = document.getElementById('lastUpdated');
        
        // Pagination elements
        const prevPageMobile = document.getElementById('prevPageMobile');
        const nextPageMobile = document.getElementById('nextPageMobile');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const paginationNumbers = document.getElementById('paginationNumbers');
        const paginationFrom = document.getElementById('paginationFrom');
        const paginationTo = document.getElementById('paginationTo');
        const paginationTotal = document.getElementById('paginationTotal');
        
        // Add reference to refresh button
        const refreshButton = document.getElementById('refreshData');
        const retryButton = document.getElementById('retryButton');
        
        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 20;
        let totalItems = 0;
        let filteredAssets = [];
        
        // Format numbers
        function formatNumber(num, decimals = 2) {
            if (isNaN(num)) return '0.00';
            return num.toLocaleString(undefined, {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        }
        
        // Format large numbers (millions, billions)
        function formatLargeNumber(num) {
            if (isNaN(num)) return '$0.00';
            
            if (num >= 1000000000000) {
                return '$' + formatNumber(num / 1000000000000) + 'T';
            }
            if (num >= 1000000000) {
                return '$' + formatNumber(num / 1000000000) + 'B';
            }
            if (num >= 1000000) {
                return '$' + formatNumber(num / 1000000) + 'M';
            }
            return '$' + formatNumber(num);
        }
        
        // Get crypto icon URL
        function getCryptoIcon(symbol) {
            // Use multiple sources for redundancy
            const symbolLower = symbol.toLowerCase();
            
            // Try using GitHub's cryptocurrency-icons repository
            return `https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/${symbolLower}.svg`;
        }
        
        // Get fiat icon URL
        function getFiatIcon(symbol) {
            const currencyFlags = {
                'USD': 'us', 'EUR': 'eu', 'GBP': 'gb', 'JPY': 'jp', 'AUD': 'au',
                'CAD': 'ca', 'CHF': 'ch', 'CNY': 'cn', 'NZD': 'nz', 'SGD': 'sg',
                'HKD': 'hk', 'SEK': 'se', 'NOK': 'no', 'DKK': 'dk', 'KRW': 'kr',
                'INR': 'in', 'BRL': 'br', 'RUB': 'ru', 'ZAR': 'za', 'MXN': 'mx',
                'IDR': 'id', 'MYR': 'my', 'THB': 'th', 'TRY': 'tr', 'SAR': 'sa',
                'AED': 'ae', 'ILS': 'il', 'PLN': 'pl', 'PHP': 'ph', 'CZK': 'cz',
                'HUF': 'hu', 'RON': 'ro', 'ISK': 'is', 'HRK': 'hr', 'BGN': 'bg'
            };
            const countryCode = currencyFlags[symbol] || 'us';
            return `https://flagcdn.com/48x36/${countryCode}.png`;
        }
        
        // Get stock icon URL
        function getStockIcon(symbol) {
            return `https://financialmodelingprep.com/image-stock/${symbol}.png`;
        }
        
        // Get asset icon with fallback
        function getAssetIcon(asset) {
            try {
                // First check if we already have an image URL from API response
                if (asset.image) {
                    return asset.image;
                }
                
                if (asset.type === 'crypto') {
                    return getCryptoIcon(asset.symbol);
                } else if (asset.type === 'fiat') {
                    return getFiatIcon(asset.symbol);
                } else if (asset.type === 'stock') {
                    return getStockIcon(asset.symbol);
                }
            } catch (e) {
                console.error('Error getting icon:', e);
            }
            // More visible fallback with larger text
            return `https://via.placeholder.com/48/4A5568/FFFFFF?text=${asset.symbol.slice(0, 2)}`;
        }
        
        // Fetch crypto data from CoinGecko API with better error handling and rate limit management
        async function fetchCryptoData() {
            try {
                // First try CoinGecko API
                const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=250&page=1&sparkline=false&price_change_percentage=24h', {
                    headers: {
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    }
                });
                
                if (!response.ok) {
                    // If CoinGecko fails, try alternative API
                    return fetchCryptoDataAlternative();
                }
                
                const data = await response.json();
                
                return data.map(crypto => ({
                    symbol: crypto.symbol.toUpperCase(),
                    name: crypto.name,
                    type: 'crypto',
                    price: crypto.current_price,
                    change24h: crypto.price_change_percentage_24h,
                    marketCap: crypto.market_cap,
                    volume: crypto.total_volume,
                    image: crypto.image
                }));
            } catch (error) {
                console.error('Error fetching crypto data from CoinGecko:', error);
                return fetchCryptoDataAlternative();
            }
        }
        
        // Alternative crypto data source as a fallback
        async function fetchCryptoDataAlternative() {
            try {
                // Try CryptoCompare as a fallback
                const response = await fetch('https://min-api.cryptocompare.com/data/top/mktcapfull?limit=100&tsym=USD&api_key=6994a7265d2d0ad7b35a3de4ff877b7c54d8e922f7c7c05141a4583ed300fcfd');
                
                if (!response.ok) throw new Error('Alternative API response not OK');
                
                const result = await response.json();
                
                if (result.Response === "Error") {
                    throw new Error(result.Message);
                }
                
                return result.Data.map(item => {
                    const crypto = item.RAW?.USD;
                    return {
                        symbol: item.CoinInfo.Name,
                        name: item.CoinInfo.FullName,
                        type: 'crypto',
                        price: crypto?.PRICE || 0,
                        change24h: crypto?.CHANGEPCT24HOUR || 0,
                        marketCap: crypto?.MKTCAP || 0,
                        volume: crypto?.TOTALVOLUME24H || 0,
                        image: `https://www.cryptocompare.com${item.CoinInfo.ImageUrl}`
                    };
                });
            } catch (error) {
                console.error('Error fetching alternative crypto data:', error);
                return []; // If all fails, return empty array
            }
        }
        
        // Fetch fiat data with real forex API
        async function fetchFiatData() {
            try {
                // Try to use a real forex API
                const response = await fetch('https://open.er-api.com/v6/latest/USD');
                
                if (!response.ok) throw new Error('Forex API response not OK');
                
                const data = await response.json();
                
                if (!data.rates) throw new Error('Invalid forex data format');
                
                // Convert to our format
                return Object.entries(data.rates).map(([symbol, rate]) => {
                    // Generate realistic fluctuation values
                    const change24h = (Math.random() * 2 - 1) * 0.5; // +/- 0.5%
                    
                    return {
                        symbol: symbol,
                        name: getCurrencyName(symbol),
                        type: 'fiat',
                        price: 1/rate, // Inverse of rate to get USD value
                        change24h: change24h,
                        marketCap: 1000000000000 * (0.5 + Math.random() * 2), // Mock values
                        volume: 10000000000 * (0.5 + Math.random() * 2) // Mock values
                    };
                });
            } catch (error) {
                console.error('Error fetching forex data:', error);
                // Fall back to the mock data if API fails
                return fetchFiatDataMock();
            }
        }
        
        // Utility function to get currency names
        function getCurrencyName(symbol) {
            const currencyNames = {
                'USD': 'US Dollar', 'EUR': 'Euro', 'GBP': 'British Pound', 'JPY': 'Japanese Yen',
                'AUD': 'Australian Dollar', 'CAD': 'Canadian Dollar', 'CHF': 'Swiss Franc',
                'CNY': 'Chinese Yuan', 'NZD': 'New Zealand Dollar', 'SEK': 'Swedish Krona',
                // ... add more as needed
            };
            return currencyNames[symbol] || symbol;
        }
        
        // Original mock function as fallback
        function fetchFiatDataMock() {
            // Major world currencies with mock data
            const fiats = [
                { symbol: 'USD', name: 'US Dollar', rate: 1.0, change24h: 0 },
                { symbol: 'EUR', name: 'Euro', rate: 0.93, change24h: -0.12 },
                { symbol: 'GBP', name: 'British Pound', rate: 0.79, change24h: 0.25 },
                { symbol: 'JPY', name: 'Japanese Yen', rate: 151.23, change24h: -0.45 },
                { symbol: 'AUD', name: 'Australian Dollar', rate: 1.52, change24h: 0.18 },
                { symbol: 'CAD', name: 'Canadian Dollar', rate: 1.36, change24h: 0.07 },
                { symbol: 'CHF', name: 'Swiss Franc', rate: 0.91, change24h: -0.03 },
                { symbol: 'CNY', name: 'Chinese Yuan', rate: 7.23, change24h: 0.02 },
                { symbol: 'HKD', name: 'Hong Kong Dollar', rate: 7.83, change24h: 0.01 },
                { symbol: 'NZD', name: 'New Zealand Dollar', rate: 1.66, change24h: 0.22 },
                { symbol: 'SEK', name: 'Swedish Krona', rate: 10.68, change24h: -0.15 },
                { symbol: 'KRW', name: 'South Korean Won', rate: 1345.67, change24h: 0.33 },
                { symbol: 'SGD', name: 'Singapore Dollar', rate: 1.35, change24h: 0.08 },
                { symbol: 'NOK', name: 'Norwegian Krone', rate: 10.72, change24h: -0.21 },
                { symbol: 'MXN', name: 'Mexican Peso', rate: 16.83, change24h: 0.42 },
                { symbol: 'INR', name: 'Indian Rupee', rate: 83.42, change24h: -0.07 },
                { symbol: 'BRL', name: 'Brazilian Real', rate: 5.06, change24h: 0.15 },
                { symbol: 'ZAR', name: 'South African Rand', rate: 18.92, change24h: -0.28 },
                { symbol: 'RUB', name: 'Russian Ruble', rate: 92.45, change24h: 0.65 },
                { symbol: 'TRY', name: 'Turkish Lira', rate: 32.12, change24h: -0.52 }
            ];
            
            // Add some random variation to make it look live
            return fiats.map(fiat => ({
                ...fiat,
                rate: fiat.rate * (1 + (Math.random() * 0.002 - 0.001)),
                change24h: fiat.change24h + (Math.random() * 0.1 - 0.05),
                marketCap: 1000000000000 * (0.5 + Math.random() * 2), // Mock market cap
                volume: 10000000000 * (0.5 + Math.random() * 2) // Mock volume
            }));
        }
        
        // Fetch stock data with real API
        async function fetchStockData() {
            try {
                // Create an array of popular stock symbols
                const symbols = ['AAPL', 'MSFT', 'GOOGL', 'AMZN', 'TSLA', 'META', 'NVDA', 'JPM', 'V', 'WMT',
                               'MA', 'PG', 'JNJ', 'HD', 'BAC', 'XOM', 'PFE', 'DIS', 'CSCO', 'KO'];
                               
                // Try to use Finnhub API (you would need to replace the token with your own)
                const promises = symbols.map(symbol => 
                    fetch(`https://finnhub.io/api/v1/quote?symbol=${symbol}&token=c9j1ouaad3i9rj7j25kg`)
                        .then(response => response.ok ? response.json() : null)
                        .then(data => {
                            if (!data || !data.c) return null;
                            
                            return {
                                symbol: symbol,
                                name: getStockName(symbol),
                                type: 'stock',
                                price: data.c,
                                change24h: ((data.c - data.pc) / data.pc) * 100,
                                marketCap: data.c * 1000000000, // Approximate market cap
                                volume: data.v || 0
                            };
                        })
                        .catch(() => null)
                );
                
                const results = await Promise.all(promises);
                const validResults = results.filter(item => item !== null);
                
                return validResults.length > 0 ? validResults : fetchStockDataMock();
            } catch (error) {
                console.error('Error fetching stock data:', error);
                return fetchStockDataMock();
            }
        }
        
        // Utility function to get stock names
        function getStockName(symbol) {
            const stockNames = {
                'AAPL': 'Apple Inc.', 'MSFT': 'Microsoft Corp.', 'GOOGL': 'Alphabet Inc.',
                'AMZN': 'Amazon.com Inc.', 'TSLA': 'Tesla Inc.', 'META': 'Meta Platforms',
                'NVDA': 'NVIDIA Corp.', 'JPM': 'JPMorgan Chase', 'V': 'Visa Inc.',
                'WMT': 'Walmart Inc.', 'MA': 'Mastercard Inc.', 'PG': 'Procter & Gamble',
                'JNJ': 'Johnson & Johnson', 'HD': 'Home Depot Inc.', 'BAC': 'Bank of America',
                'XOM': 'Exxon Mobil Corp.', 'PFE': 'Pfizer Inc.', 'DIS': 'Walt Disney Co.',
                'CSCO': 'Cisco Systems', 'KO': 'Coca-Cola Co.'
            };
            return stockNames[symbol] || symbol;
        }
        
        // Original mock function as fallback
        function fetchStockDataMock() {
            // Major world stocks with mock data
            const stocks = [
                { symbol: 'AAPL', name: 'Apple Inc.', price: 175.23, change24h: 1.25 },
                { symbol: 'MSFT', name: 'Microsoft Corp.', price: 420.45, change24h: 0.78 },
                { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 155.67, change24h: -0.32 },
                { symbol: 'AMZN', name: 'Amazon.com Inc.', price: 185.34, change24h: 2.15 },
                { symbol: 'TSLA', name: 'Tesla Inc.', price: 175.89, change24h: -1.45 },
                { symbol: 'META', name: 'Meta Platforms', price: 485.32, change24h: 0.92 },
                { symbol: 'NVDA', name: 'NVIDIA Corp.', price: 890.12, change24h: 3.45 },
                { symbol: 'JPM', name: 'JPMorgan Chase', price: 195.67, change24h: -0.56 },
                { symbol: 'V', name: 'Visa Inc.', price: 275.43, change24h: 0.23 },
                { symbol: 'WMT', name: 'Walmart Inc.', price: 59.87, change24h: 0.12 },
                { symbol: 'MA', name: 'Mastercard Inc.', price: 465.32, change24h: 0.45 },
                { symbol: 'PG', name: 'Procter & Gamble', price: 165.78, change24h: -0.23 },
                { symbol: 'JNJ', name: 'Johnson & Johnson', price: 152.34, change24h: 0.15 },
                { symbol: 'HD', name: 'Home Depot Inc.', price: 345.67, change24h: 0.67 },
                { symbol: 'BAC', name: 'Bank of America', price: 37.89, change24h: -0.89 },
                { symbol: 'XOM', name: 'Exxon Mobil Corp.', price: 118.76, change24h: 1.23 },
                { symbol: 'PFE', name: 'Pfizer Inc.', price: 27.65, change24h: -0.45 },
                { symbol: 'DIS', name: 'Walt Disney Co.', price: 102.34, change24h: 0.56 },
                { symbol: 'CSCO', name: 'Cisco Systems', price: 49.87, change24h: -0.12 },
                { symbol: 'KO', name: 'Coca-Cola Co.', price: 59.43, change24h: 0.23 }
            ];
            
            // Add some random variation to make it look live
            return stocks.map(stock => ({
                ...stock,
                price: stock.price * (1 + (Math.random() * 0.01 - 0.005)),
                change24h: stock.change24h + (Math.random() * 0.2 - 0.1),
                marketCap: stock.price * (1000000000 + Math.random() * 9000000000), // Mock market cap
                volume: stock.price * (10000000 + Math.random() * 90000000) // Mock volume
            }));
        }
        
        // Fetch all market data
        async function fetchMarketData() {
            loadingRow.classList.remove('hidden');
            errorRow.classList.add('hidden');
            emptyRow.classList.add('hidden');
            
            // Add loading animation to refresh button
            if (refreshButton) {
                refreshButton.disabled = true;
                refreshButton.innerHTML = `
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
            }
            
            try {
                const [cryptoData, fiatData, stockData] = await Promise.all([
                    fetchCryptoData(),
                    fetchFiatData(),
                    fetchStockData()
                ]);
                
                // Combine all data
                const allAssets = [
                    ...cryptoData,
                    ...fiatData.map(fiat => ({ ...fiat, type: 'fiat' })),
                    ...stockData.map(stock => ({ ...stock, type: 'stock' }))
                ];
                
                // Update last updated time with nicer format
                const now = new Date();
                lastUpdatedEl.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                lastUpdatedEl.title = now.toLocaleString();
                
                return allAssets;
            } catch (error) {
                console.error('Error fetching market data:', error);
                errorRow.classList.remove('hidden');
                return [];
            } finally {
                loadingRow.classList.add('hidden');
                
                // Reset refresh button
                if (refreshButton) {
                    refreshButton.disabled = false;
                    refreshButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    `;
                }
            }
        }
        
        // Sort assets
        function sortAssets(assets, sortBy) {
            return [...assets].sort((a, b) => {
                switch (sortBy) {
                    case 'name':
                        return a.name.localeCompare(b.name);
                    case 'name_desc':
                        return b.name.localeCompare(a.name);
                    case 'price':
                        return a.price - b.price;
                    case 'price_desc':
                        return b.price - a.price;
                    case 'change':
                        return (a.change24h || 0) - (b.change24h || 0);
                    case 'change_desc':
                        return (b.change24h || 0) - (a.change24h || 0);
                    default:
                        return 0;
                }
            });
        }
        
        // Filter assets
        function filterAssets(assets, typeFilter, searchQuery) {
            return assets.filter(asset => {
                const matchesType = typeFilter === 'all' || asset.type === typeFilter;
                const matchesSearch = searchQuery === '' || 
                    asset.symbol.toLowerCase().includes(searchQuery) || 
                    asset.name.toLowerCase().includes(searchQuery);
                return matchesType && matchesSearch;
            });
        }
        
        // Render pagination
        function renderPagination(totalItems, currentPage, itemsPerPage) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            paginationTotal.textContent = totalItems;
            paginationFrom.textContent = ((currentPage - 1) * itemsPerPage) + 1;
            paginationTo.textContent = Math.min(currentPage * itemsPerPage, totalItems);
            
            // Clear existing pagination numbers
            paginationNumbers.innerHTML = '';
            
            // Always show first page
            addPageNumber(1, currentPage);
            
            // Show ellipsis if needed after first page
            if (currentPage > 3) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-600 bg-gray-700 text-sm font-medium text-gray-300';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
            
            // Show current page and neighbors
            const startPage = Math.max(2, currentPage - 1);
            const endPage = Math.min(totalPages - 1, currentPage + 1);
            
            for (let i = startPage; i <= endPage; i++) {
                addPageNumber(i, currentPage);
            }
            
            // Show ellipsis if needed before last page
            if (currentPage < totalPages - 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-600 bg-gray-700 text-sm font-medium text-gray-300';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
            
            // Always show last page if there are multiple pages
            if (totalPages > 1) {
                addPageNumber(totalPages, currentPage);
            }
            
            // Enable/disable prev/next buttons
            prevPageMobile.disabled = prevPage.disabled = currentPage === 1;
            nextPageMobile.disabled = nextPage.disabled = currentPage === totalPages;
            
            if (currentPage === 1) {
                prevPage.classList.add('opacity-50', 'cursor-not-allowed');
                prevPageMobile.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                prevPage.classList.remove('opacity-50', 'cursor-not-allowed');
                prevPageMobile.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            if (currentPage === totalPages) {
                nextPage.classList.add('opacity-50', 'cursor-not-allowed');
                nextPageMobile.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                nextPage.classList.remove('opacity-50', 'cursor-not-allowed');
                nextPageMobile.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        
        function addPageNumber(page, currentPage) {
            const pageElement = document.createElement('a');
            pageElement.href = '#';
            pageElement.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                page === currentPage 
                    ? 'z-10 bg-blue-600 border-blue-600 text-white' 
                    : 'bg-gray-700 border-gray-600 text-gray-300 hover:bg-gray-600'
            }`;
            pageElement.textContent = page;
            pageElement.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = page;
                renderAssets();
            });
            paginationNumbers.appendChild(pageElement);
        }
        
        // Render assets
        async function renderAssets() {
            const typeFilter = assetTypeSelect.value;
            const searchQuery = searchInput.value.toLowerCase();
            const sortBy = sortBySelect.value;
            
            // Get all assets
            let allAssets = await fetchMarketData();
            if (allAssets.length === 0) return;
            
            // Filter assets
            filteredAssets = filterAssets(allAssets, typeFilter, searchQuery);
            
            // Sort assets
            filteredAssets = sortAssets(filteredAssets, sortBy);
            
            // Update pagination
            totalItems = filteredAssets.length;
            renderPagination(totalItems, currentPage, itemsPerPage);
            
            // Clear table
            assetsTableBody.innerHTML = '';
            
            // Show empty state if no assets
            if (filteredAssets.length === 0) {
                emptyRow.classList.remove('hidden');
                assetsTableBody.appendChild(emptyRow);
                return;
            } else {
                emptyRow.classList.add('hidden');
            }
            
            // Get current page items
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredAssets.length);
            const currentItems = filteredAssets.slice(startIndex, endIndex);
            
            // Add assets to table with improved styling
            currentItems.forEach(asset => {
                const change24h = asset.change24h || 0;
                const changeClass = change24h >= 0 ? 'text-green-600' : 'text-red-600';
                const changeIcon = change24h >= 0 ? 
                    '<svg class="inline-block h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>' : 
                    '<svg class="inline-block h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>';
                
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 transition-colors duration-150';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center">
                                <img src="${getAssetIcon(asset)}" alt="${asset.symbol}" class="h-6 w-6 object-contain" 
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${asset.symbol.slice(0, 2)}&background=0D8ABC&color=fff&size=128&bold=true'">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${asset.symbol}</div>
                                <div class="text-sm text-gray-500">${asset.name}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$${formatNumber(asset.price, asset.type === 'fiat' ? 4 : 2)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="inline-flex items-center ${changeClass} text-sm">
                            ${changeIcon}
                            <span>${Math.abs(change24h).toFixed(2)}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        ${asset.marketCap ? formatLargeNumber(asset.marketCap) : 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        ${asset.volume ? formatLargeNumber(asset.volume) : 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('trade.index') }}?asset=${asset.symbol}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-lg mr-2 transition-colors">Trade</a>
                        <a href="{{ route('crypto.deposit.index') }}" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-3 py-1 rounded-lg transition-colors">Deposit</a>
                    </td>
                `;
                assetsTableBody.appendChild(row);
            });
        }
        
        // Event listeners
        assetTypeSelect.addEventListener('change', () => {
            currentPage = 1;
            renderAssets();
        });
        
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            renderAssets();
        });
        
        sortBySelect.addEventListener('change', renderAssets);
        
        prevPage.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderAssets();
            }
        });
        
        nextPage.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < Math.ceil(totalItems / itemsPerPage)) {
                currentPage++;
                renderAssets();
            }
        });
        
        prevPageMobile.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderAssets();
            }
        });
        
        nextPageMobile.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < Math.ceil(totalItems / itemsPerPage)) {
                currentPage++;
                renderAssets();
            }
        });
        
        // Add event listener for refresh button
        if (refreshButton) {
            refreshButton.addEventListener('click', renderAssets);
        }
        
        // Add event listener for retry button
        if (retryButton) {
            retryButton.addEventListener('click', renderAssets);
        }
        
        // Initial load
        renderAssets();
        
        // Refresh data more frequently for real-time feel
        setInterval(renderAssets, 2 * 60 * 1000); // Every 2 minutes
    });
</script>